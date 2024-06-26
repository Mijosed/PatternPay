<?php

namespace PaymentGateway\Stripe;

use PaymentGateway\PaymentGatewayInterface;
use PaymentGateway\Transaction;
use PaymentGateway\TransactionResult;

class StripeGateway implements PaymentGatewayInterface {
    private $apiKey;

    public function initialize(array $config): void {
        $this->apiKey = $config['api_key'];
    }

    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        return new Transaction($amount, $currency, $description);
    }

    public function executeTransaction(Transaction $transaction): TransactionResult {
        $success = true; 
        $message = 'Transaction successful';
        return new TransactionResult($success, $message);
    }

    public function cancelTransaction(Transaction $transaction): bool {
        return true; 
    }

    public function getTransactionStatus(Transaction $transaction): string {
        return 'succeeded';
    }
}
