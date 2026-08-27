<?php

namespace App\Services;

use Binance\API;

class BinanceService
{
    protected $api;

    public function __construct()
    {
        $this->api = new API(env('BINANCE_API_KEY'), env('BINANCE_API_SECRET'));
    }

    // Get the account information (balance, orders, etc.)
    public function getAccountInfo()
    {
        return $this->api->account();
    }

    // Get the price of a specific coin (e.g., BTCUSDT)
    public function getPrice($symbol)
    {
        return $this->api->prices($symbol);
    }

    // Other Binance functionalities like order creation, withdrawal, etc.
}
