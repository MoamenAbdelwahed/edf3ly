<?php

namespace Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Domain\Contracts\Repository\RepositoryInterface;
use Domain\Entities\Product;

/**
 * Class ProductRepository
 * @package Infrastructure\Repositories
 */
class ProductRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * ProductRepository constructor.
     * @param EntityManager $entityManager
     * @param Product $entity
     */
    public function __construct(EntityManager $entityManager, Product $entity)
    {
        parent::__construct($entityManager, $entity);
    }
}
