<?php

namespace Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use LaravelDoctrine\ORM\Serializers\Jsonable;

/**
 * Class AbstractRepository
 * @package Infrastructure\Repositories\AbsctractRepository
 */
abstract class AbstractRepository
{
    use Jsonable;

    /**
     * @var mixed $entity
     */
    protected $entity;

    /**
     * @var EntityManager $entityMapper
     */
    protected $entityMapper;

    /**
     * @var string $entityNamespace
     */
    protected $entityNamespace;

    /**
     * AbstractRepository constructor.
     * @param EntityManager $entityManager
     * @param $entity
     */
    public function __construct(EntityManager $entityManager, $entity)
    {
        $this->entityMapper = $entityManager;
        $this->entity = $entity;
        $this->entityNamespace = get_class($entity);
    }

    /**
     * @param int $entityId
     * @return null|object
     */
    public function find( $entityId)
    {
        return $this->entityMapper->find($this->entityNamespace, $entityId);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->entityMapper->getRepository($this->entityNamespace)->findAll();
    }

    /**
     * @param $arrKeyValue
     * @param null $order
     * @return array|object[]
     */
    public function findAllBy($arrKeyValue, $order = null)
    {
        return $this->entityMapper->getRepository($this->entityNamespace)->findBy($arrKeyValue, $order);
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function save($entity)
    {
        $this->entityMapper->persist($entity);
        $this->entityMapper->flush();
        return $entity;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function flush()
    {
        $this->entityMapper->flush();
        $this->entityMapper->clear();
    }

    /**
     * @param $entity
     * @param $arrAttributes
     * @return mixed
     */
    public function update($entity, $arrAttributes)
    {
        $acceptedAttributes = [];
        foreach ($arrAttributes as $key => $value) {
            if (in_array($key, $this->getAllEntityFieldsNames()) ||
                in_array($key, $this->getAllEntityAssociationNames())) {
                $acceptedAttributes[$key] = $value;
            }
        }
        $this->setAttributes($entity,$acceptedAttributes);
        $this->addRelatedEntity($entity,$acceptedAttributes);
        return $this->save($entity);
    }

    /**
     * @param $entity
     */
    public function delete($entity)
    {
        $this->entityMapper->remove($entity);
        $this->entityMapper->flush();
    }

    /**
     * @param $entity
     * @param null $arrAttributes
     * @return mixed
     */
    public function load($entity, $arrAttributes=null)
    {
        if($arrAttributes){
            $this->setAttributes($entity,$arrAttributes);
            $this->loadRelatedEntity($entity,$arrAttributes);
        }
        return $entity;
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    private function setAttributes($entity,$arrAttributes)
    {
        foreach ($arrAttributes as $attr => $val) {
            if (method_exists($entity, 'set'.$attr)) {
                $param = new \ReflectionParameter(array(get_class($entity), 'set'.$attr), 0);
                if (!is_null($param->getClass())) {
                    $entityClass = $param->getClass()->name;
                    $value = $this->findExternal($entityClass, $val);
                    if (!empty($value)) {
                        $entity->{'set'.$attr}($value);
                    }
                } else {
                    if (!empty($val)) {
                        $entity->{'set'.$attr}($val);
                    }
                }
            }
        }
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    private function addRelatedEntity($entity,$arrAttributes)
    {
        foreach($arrAttributes as $parentAttribute => $values){
            if(is_array($values)) {
                foreach ($values as $val) {
                    if(method_exists($entity, 'add'.$parentAttribute)){

                        $param = new \ReflectionParameter(array($this->entityNamespace, 'add'.$parentAttribute), 0);

                        if(!is_null($param->getClass())){

                            $entityClass = $param->getClass()->name;
                            $newRelatedEntity  = new $entityClass;

                            $this->setAttributes($newRelatedEntity,$val);

                            if(method_exists($newRelatedEntity,'setCreatedAt')){
                                $newRelatedEntity->setCreatedAt(new \DateTime('now'));
                            }

                            $parentClassId  = get_class($entity);
                            $parentClassId = substr($parentClassId, strrpos($parentClassId, '\\') + 1);

                            $newRelatedEntity->{'set'.$parentClassId}($entity);

                            $entity->{'add'.$parentAttribute}($newRelatedEntity);
                        }
                    } elseif(method_exists($entity, 'addMultiple'.$parentAttribute)) {
                        $param = new \ReflectionParameter(array($this->entityNamespace, 'addMultiple'.$parentAttribute), 0);
                        if ( ! is_null($param->getClass())) {
                            $entityClass = $param->getClass()->name;
                            $allRefrencies = [];
                            foreach ($values as $value) {
                                $allRefrencies[] = $this->findExternal($entityClass,$value);
                            }
                            $entity->{'setMultiple'.$parentAttribute}($allRefrencies);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    private function loadRelatedEntity($entity,$arrAttributes)
    {
        foreach($arrAttributes as $attr => $val){
            if(is_array($val)){
                foreach ($val as $id){
                    if(method_exists($entity, 'add'.$attr)){

                        $param = new \ReflectionParameter(array($this->entityNamespace, 'add'.$attr), 0);

                        if(!is_null($param->getClass())){
                            $entityClass = $param->getClass()->name;

                            $value = $this->findExternal($entityClass,$id);
                            $entity->{'add'.$attr}($value);
                        }
                    }
                }
            }
        }
    }
}
