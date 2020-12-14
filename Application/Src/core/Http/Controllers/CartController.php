<?php

namespace Application\Src\Http\Controllers;

use Application\Src\Constants\CartConstants;
use Application\Src\Constants\CurrencyConstants;
use Application\Src\Helpers\CurrencyHelper;
use Application\Src\Http\Request\CartRequestValidation;
use Domain\Entities\DiscountOffer;
use Domain\Entities\Product;
use Domain\Services\ProductService;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package Application\Src\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct($productService);
    }

    /**
     * @inheritDoc
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $post = $this->removeEmpty($post);
        $this->getRequestValidationObject()->validateCreation($post);
        if (isset($post['productIds']) && !empty($post['productIds'])) {
            $products = $this->applicationService->findAllBy(['id' => $post['productIds']]);
        }
        $totalPrice = $this->calculateTotalPrice($products);
        if (isset($post['currency']) && !empty($post['currency'])) {
            if ($post['currency'] != CurrencyConstants::USD) {
                $totalPrice = CurrencyHelper::currencyConverter($post['currency'], $totalPrice);
            }
        }
        return response()->json(['totalPrice' => $totalPrice]);
    }

    /**
     * @return CartRequestValidation
     */
    public function getRequestValidationObject()
    {
        return new CartRequestValidation();
    }

    /**
     * @param array $products
     * @return float|int
     */
    private function calculateTotalPrice(array $products)
    {
        $taxes = 0;
        $totalPriceBeforeOffers = 0;
        $totalDiscounts = 0;
        /** @var Product $product */
        foreach ($products as $product) {
            $taxes += (CartConstants::TAX * intval($product->getPriceInUSD())) / 100;
            $totalPriceBeforeOffers += $product->getPriceInUSD();
            if ($product->getOffer()) {
                $offer = $product->getOffer();
                if ($offer->getIsDiscount()) {
                    $totalDiscounts += ($offer->getPercentage() * $product->getPriceInUSD()) / 100;
                } else {
                    if ($offer->getPercentage()) {
                        $actualOffer = (($offer->getPercentage() / 100) * $offer->getGetCount()) / ($offer->getGetCount() + $offer->getBuyCount());
                    } else {
                        $actualOffer = $offer->getGetCount() / ($offer->getGetCount() + $offer->getBuyCount());
                    }
                    $totalDiscounts += $actualOffer * $product->getPriceInUSD() * ($offer->getBuyCount() + $offer->getGetCount());
                }
            }
        }
        return $taxes + ($totalPriceBeforeOffers - $totalDiscounts);
    }
}
