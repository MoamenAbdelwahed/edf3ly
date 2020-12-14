<?php

namespace Domain\Services;

use Domain\Abstractions\AbstractDomainService;
use Domain\Contracts\Service\ServiceInterface;
use Infrastructure\Repositories\ProductRepository;

/**
 * Class ProductService
 * @package Domain\Services
 */
class ProductService extends AbstractDomainService implements ServiceInterface
{
    /**
     * ProductService constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }
}
