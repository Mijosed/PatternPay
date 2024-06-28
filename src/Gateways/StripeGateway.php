<?php

namespace PatternPay\Gateways;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripeGateway implements PaymentGatewayInterface {
    private $apiKey;

    public function initialize(array $config): void {
        $this->apiKey = $config['api_key'];
        Stripe::setApiKey($this->apiKey);

        // Vérification de la connexion à l'API Stripe
        try {
            \Stripe\Balance::retrieve();
        } catch (ApiErrorException $e) {
            throw new \Exception('Invalid Stripe API Key or unable to connect to Stripe: ' . $e->getMessage());
        }
    }

    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        return new Transaction($amount, $currency, $description);
    }

    public function executeTransaction(Transaction $transaction): TransactionResult {
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $transaction->getAmount() * 100, // Stripe uses cents
                'currency' => $transaction->getCurrency(),
                'description' => $transaction->getDescription(),
                'source' => 'tok_visa', // Replace with actual token or payment method ID
            ]);
            $transaction->setTransactionId($charge->id);
            $transaction->setStatus('succeeded');
            return new TransactionResult(true, 'Transaction successful: ' . $charge->id);
        } catch (ApiErrorException $e) {
            $transaction->setStatus('failed');
            return new TransactionResult(false, 'Transaction failed: ' . $e->getMessage());
        }
    }

    public function cancelTransaction(Transaction $transaction): TransactionResult {
        try {
            $charge = \Stripe\Charge::retrieve($transaction->getTransactionId());
            $refund = \Stripe\Refund::create([
                'charge' => $charge->id,
            ]);
            $transaction->setStatus('cancelled');
            return new TransactionResult(true, 'Transaction cancelled successfully: ' . $refund->id);
        } catch (ApiErrorException $e) {
            return new TransactionResult(false, 'Cancellation failed: ' . $e->getMessage());
        }
    }

    public function getTransactionStatus(Transaction $transaction): string {
        // Implémentation de la récupération du statut de la transaction
        return 'succeeded';
    }
}
