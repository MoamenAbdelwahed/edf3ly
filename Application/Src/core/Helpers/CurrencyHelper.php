<?php

namespace Application\Src\Helpers;

use Application\Src\Constants\CurrencyConstants;

/**
 * Class CurrencyHelper
 * @package Application\Src\Helpers
 */
class CurrencyHelper
{
    /**
     * @param $currency_to
     * @param $currency_input
     * @return float|int
     */
    public static function currencyConverter($currency_to, $currency_input) {
        $return_price = $currency_input;
        $req_url = "https://api.exchangerate-api.com/v4/latest/".CurrencyConstants::USD;
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            // Decoding
            $response_object = json_decode($response_json);

            $base_price = $currency_input;
            $return_price = round(($base_price * $response_object->rates->{$currency_to}), 2);
        }
        return $return_price;
    }
}
