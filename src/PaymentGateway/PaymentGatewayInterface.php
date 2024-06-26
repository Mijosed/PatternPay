<?php
namespace PaymentGateway;

interface PaymentGatewayInterface {
    public function initialize(array $config);
    public function createTransaction(float $amount, string $currency, string $description);
    public function executeTransaction($transaction);
    public function cancelTransaction($transaction);
    public function getStatus($transaction);
}
