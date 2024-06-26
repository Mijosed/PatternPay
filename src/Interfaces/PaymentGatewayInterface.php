<?php

namespace Mijos\PatternPay\Interfaces;

interface PaymentGatewayInterface {
    public function initialize(array $credentials);
    public function createTransaction(float $amount, string $currency, string $description);
    public function executeTransaction($transaction);
    public function cancelTransaction($transaction);
}