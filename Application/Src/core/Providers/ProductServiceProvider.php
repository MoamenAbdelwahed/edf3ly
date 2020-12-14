<?php

namespace Application\Src\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ProductServiceProvider
 * @package Application\Src\Providers
 */
class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Domain\Contracts\Repository\RepositoryInterface',
            'Infrastructure\Repositories\ProductRepository');
        $this->app->bind('Domain\Contracts\Service\ServiceInterface', 'Domain\Services\ProductService');
    }
}
