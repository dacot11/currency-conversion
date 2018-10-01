<?php

namespace App\Converter;

use App\Db\RateDAO;


class Loader
{
    private $rateDAO;

    public function __construct(RateDAO $rateDAO) {
        $this->rateDAO = $rateDAO;
    }

    /**
     * Load consumes the conversion rates from a 3rt party API and persists them in the database.
     * Using SimpleXMLElement to fetch the XML data for simplicity.
     * An http client should be used and max items per request and/or pagination should be set for handling big sets of data in production environments.
     *
     * @todo Error handling.
     * @todo Use a 'Rate' object for better data handling.
     */
    public function load(string $url) {

        $rateXML = new \SimpleXMLElement($url, 0, true);

        foreach ($rateXML->children() as $rateXmlObj) {

            $rate = [
                'currency' => (string) $rateXmlObj->currency,
                'rate' => (float) $rateXmlObj->rate
            ];

            $this->rateDAO->save($rate);
        }

        return;
    }
    
}