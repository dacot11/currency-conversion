<?php

namespace App\Db;

class RateDAO
{
    private $conn;

    public function __construct(\PDO $conn) {
        $this->conn = $conn;
    }

    /**
     * Save persists a conversion rate in the database.
     * It will insert a new rate if the currency code does not exist
     *  or update one for an existing currency code.
     *
     * @param array $rate
     *
     * @todo Handle errors.
     * @todo Use a 'Rate' object for better data handling.
     */
    public function save(array $rate) {

        $sql = "INSERT INTO rate (currency, rate) VALUES (:currency, :rate) ON DUPLICATE KEY UPDATE `rate` = :rate";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($rate);

        return;
    }

    /**
     * FindByCurrency fetches a conversion rate for a given currency code.
     *
     * @param string $currency
     * @return float|false
     *
     * @todo Handle errors.
     */
    public function findByCurrency(string $currency) {

        $sql = "SELECT rate FROM rate WHERE currency = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$currency]);

        return $stmt->fetchColumn();
    }
}