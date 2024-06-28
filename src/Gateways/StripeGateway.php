<?php

namespace PatternPay\Gateways;

use PatternPay\Factories\TransactionFactory;
use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripeGateway implements PaymentGatewayInterface, TransactionFactory{
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
        try {
            // Récupérer l'ID de la transaction depuis l'objet Transaction
            $transactionId = $transaction->getTransactionId();
    
            // Interroger l'API Stripe pour obtenir les détails de la transaction
            $stripeTransaction = \Stripe\Charge::retrieve($transactionId);
    
            // Vérifier le statut de paiement
            if (!$stripeTransaction->paid) {
                return 'pending'; // Transaction en attente de paiement
            }
    
            // Vérifier le statut de capture
            if (!$stripeTransaction->captured) {
                return 'authorized'; // Transaction autorisée mais non encore capturée
            }
    
            // Vérifier le statut de remboursement
            if ($stripeTransaction->refunded) {
                return 'refunded'; // Transaction remboursée
            }
    
            // Déterminer le statut final de la transaction
            switch ($stripeTransaction->status) {
                case 'succeeded':
                    return 'succeeded'; // Transaction réussie
                case 'failed':
                    return 'failed'; // Transaction échouée
                case 'canceled':
                    return 'canceled'; // Transaction annulée
                default:
                    return 'unknown'; // Autres cas non prévus
            }
        } catch (ApiErrorException $e) {
            // Gérer les erreurs d'API Stripe
            // Vous pouvez journaliser l'erreur ou retourner un statut par défaut
            return 'unknown';
        }
    }
    
}
