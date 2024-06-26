<?php

namespace Mijos\PatternPay\Gateways;

use Mijos\PatternPay\Interfaces\PaymentGatewayInterface;
use Mijos\PatternPay\Transactions\Transaction;
use Mijos\PatternPay\Transactions\TransactionStatus;

class StripeGateway implements PaymentGatewayInterface {
    private $apiKey;

    public function initialize(array $credentials) {
        $this->apiKey = $credentials['apiKey'];
    }

    public function createTransaction(float $amount, string $currency, string $description) {
        return new Transaction($amount, $currency, $description);
    }

    public function executeTransaction($transaction) {
        $transaction->setStatus(TransactionStatus::SUCCESS);
        return $transaction;
    }

    public function cancelTransaction($transaction) {
        $transaction->setStatus(TransactionStatus::CANCELLED);
        return $transaction;
    }
}
