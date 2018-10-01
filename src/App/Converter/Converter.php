<?php

namespace App\Converter;

use App\Db\RateDAO;


class Converter
{
    private $rateDAO;

    public function __construct(RateDAO $rateDAO) {
        $this->rateDAO = $rateDAO;
    }

    /**
     * Convert converts a given currency to USD based on a conversion rate.
     *
     * @param string $currency
     * @param float $value
     * @return float|null
     */
    public function convert(string $currency, float $value) {
        $rate = $this->rateDAO->findByCurrency($currency);

        if ($rate === false) {
            return null;
        }

        return $rate * $value;
    }
}