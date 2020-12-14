<?php

namespace Domain\Abstractions;

use Infrastructure\Repositories\AbstractRepository;

/**
 * Class AbstractDomainService
 * @package Domain\Abstractions
 */
abstract class AbstractDomainService
{
    /**
     * @var AbstractRepository $repository
     */
    public $repository;

    /**
     * AbstractDomainService constructor.
     * @param $repositoryContract
     */
    public function __construct($repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $entityId
     * @return object|null
     */
    public function find($entityId)
    {
        return $this->repository->find($entityId);
    }

    /**
     * @param $arrKeyValue
     * @param null $order
     * @return mixed
     */
    public function findAllBy($arrKeyValue, $order = null)
    {
        return $this->repository->findAllBy($arrKeyValue, $order);
    }

    /**
     * @param $post
     * @return mixed
     */
    public function loadNew($post)
    {
        return $this->repository->loadNew($post);
    }

    /**
     * @param $post
     * @return mixed
     */
    public function create($post)
    {
        if (!is_object($post)) {
            $post = $this->loadNew($post);
        }
        return $this->repository->save($post);
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function save($entity)
    {
        return $this->repository->save($entity);
    }

    /**
     * @param $entityId
     * @param $post
     * @return mixed
     */
    public function update($entityId, $post)
    {
        $entity = $this->find($entityId);
        return $this->repository->update($entity, $post);
    }

    /**
     * @param $entityId
     * @return mixed
     */
    public function delete($entityId)
    {
        return $this->repository->deleteById($entityId);
    }
}
