<?php

namespace PatternPay\Gateways;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Interfaces\TransactionFactory;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;
use PatternPay\Transactions\TransactionStatus;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

/**
 * Class StripeGateway
 * @package PatternPay\Gateways
 */
class StripeGateway implements PaymentGatewayInterface, TransactionFactory{
    private $apiKey;

    // Initialisation de la clé API Stripe et vérification de la connexion à l'API Stripe lors de l'instanciation de la classe StripeGateway 
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
 
    // Création d'une transaction Stripe à partir d'un montant, d'une devise et d'une description 
    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        return new Transaction($amount, $currency, $description);
    }

    // Exécution d'une transaction Stripe à partir d'une transaction Stripe 
    public function executeTransaction(Transaction $transaction): TransactionResult {
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $transaction->getAmount() * 100, // Stripe utilise des centimes pour les montants en devise 
                'currency' => $transaction->getCurrency(),
                'description' => $transaction->getDescription(),
                'source' => 'tok_visa', // Remplacer par le token de la carte de crédit du client 
            ]);
            $transaction->setTransactionId($charge->id); 
            $transaction->setStatus(TransactionStatus::SUCCESS);
            return new TransactionResult(true, 'Transaction successful: ' . $charge->id);
        } catch (ApiErrorException $e) {
            $transaction->setStatus(TransactionStatus::FAILED);
            return new TransactionResult(false, 'Transaction failed: ' . $e->getMessage());
        }
    }

    // Annulation d'une transaction Stripe à partir d'une transaction Stripe 
    public function cancelTransaction(Transaction $transaction): TransactionResult {
        try {
            $charge = \Stripe\Charge::retrieve($transaction->getTransactionId());
            $refund = \Stripe\Refund::create([
                'charge' => $charge->id,
            ]);
            $transaction->setStatus(TransactionStatus::CANCELLED);
            return new TransactionResult(true, 'Transaction cancelled successfully: ' . $refund->id);
        } catch (ApiErrorException $e) {
            return new TransactionResult(false, 'Cancellation failed: ' . $e->getMessage());
        }
    }

    // Remboursement d'une transaction Stripe à partir d'une transaction Stripe 
    public function getTransactionStatus(Transaction $transaction): string {
        try {
            $transactionId = $transaction->getTransactionId();
            $stripeTransaction = \Stripe\Charge::retrieve($transactionId);

            if (!$stripeTransaction->paid) {
                return TransactionStatus::PENDING;
            }

            if (!$stripeTransaction->captured) {
                return TransactionStatus::PENDING;
            }

            if ($stripeTransaction->refunded) {
                return TransactionStatus::REFUNDED;
            }
            // Vérification du statut de la transaction Stripe 
            switch ($stripeTransaction->status) {
                case 'succeeded':
                    return TransactionStatus::PENDING;
                case 'failed':
                    return TransactionStatus::FAILED;
                case 'canceled':
                    return TransactionStatus::CANCELLED;
                default:
                    return TransactionStatus::PENDING;
            }
        } catch (ApiErrorException $e) {
            return TransactionStatus::PENDING;
        }
    }
}
