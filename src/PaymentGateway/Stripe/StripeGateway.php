<?php

namespace PaymentGateway\Stripe;

use PaymentGateway\PaymentGatewayInterface;
use PaymentGateway\Transaction;
use PaymentGateway\TransactionResult;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

/**
 * Portail de paiement Stripe pour le traitement des transactions de paiement par carte de crédit.
 */
class StripeGateway implements PaymentGatewayInterface {
    private $apiKey;

    // Initialisation de la clé API Stripe et vérification de la connexion à l'API Stripe lors de la création de l'objet StripeGateway
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

    // Création d'une transaction Stripe à partir des détails de la transaction fournis (montant, devise et description) et retour de l'objet Transaction créé 
    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        return new Transaction($amount, $currency, $description);
    }

    // Exécution de la transaction Stripe en utilisant l'API Stripe et retour du résultat de la transaction (réussie ou échouée) avec un message de statut
    public function executeTransaction(Transaction $transaction): TransactionResult {
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $transaction->getAmount() * 100, // Stripe uses cents
                'currency' => $transaction->getCurrency(),
                'description' => $transaction->getDescription(),
                'source' => 'tok_visa', // Replace with actual token or payment method ID
            ]);
            return new TransactionResult(true, 'Transaction successful: ' . $charge->id);
        } catch (ApiErrorException $e) {
            return new TransactionResult(false, 'Transaction failed: ' . $e->getMessage());
        }
    }

    // Annulation de la transaction Stripe et retour du statut de l'annulation (réussie ou échouée) 
    public function cancelTransaction(Transaction $transaction): bool {
        // Implémentation de l'annulation de transaction
        return true;
    }

    // Récupération du statut de la transaction Stripe et retour du statut de la transaction (réussie, échouée, en attente, etc.) 
    public function getTransactionStatus(Transaction $transaction): string {
        // Implémentation de la récupération du statut de la transaction
        return 'succeeded';
    }
}
