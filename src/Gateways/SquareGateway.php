<?php
namespace PatternPay\Gateways;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Interfaces\TransactionFactory;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;
use PatternPay\Transactions\TransactionStatus;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use Square\Models\CreateRefundRequest;
use Square\Models\Money;
use Square\SquareClient;

/**
 * Classe SquareGateway
 * @package PatternPay\Gateways
 */
class SquareGateway implements PaymentGatewayInterface, TransactionFactory {
    private $client;

    /**
     * Initialise le client API de Square avec une clé API et un environnement
     */
    public function initialize(array $config): void {
        $this->client = new SquareClient([
            'accessToken' => $config['api_key'],
            'environment' => $config['environment'] ?? 'sandbox', // Utilise 'sandbox' ou 'production'
        ]);

        // Vérifie la connexion à l'API
        try {
            $this->client->getLocationsApi()->listLocations();
        } catch (ApiException $e) {
            throw new \Exception('Clé API Square invalide ou problème de connexion à Square: ' . $e->getMessage());
        }
    }

    /**
     * Crée une transaction Square à partir du montant, de la devise, et de la description
     */
    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        return new Transaction($amount, $currency, $description);
    }

    /**
     * Exécute une transaction avec Square
     */
    public function executeTransaction(Transaction $transaction): TransactionResult {
        try {
            $amountMoney = new Money();
            $amountMoney->setAmount(intval($transaction->getAmount() * 100)); // Convertit en centimes
            $amountMoney->setCurrency($transaction->getCurrency());

            $sourceId = 'REPLACE_ME_CARD_NONCE'; // Ce nonce doit être fourni par le frontend sécurisé (e.g., Square payment form)
            $idempotencyKey = uniqid();

            $createPaymentRequest = new CreatePaymentRequest($sourceId, $idempotencyKey);
            $createPaymentRequest->setAmountMoney($amountMoney);
            $createPaymentRequest->setNote($transaction->getDescription());

            $payment = $this->client->getPaymentsApi()->createPayment($createPaymentRequest);
            $transaction->setTransactionId($payment->getResult()->getId());
            $transaction->setStatus(TransactionStatus::SUCCESS);
            return new TransactionResult(true, 'Transaction réussie: ' . $payment->getResult()->getId());
        } catch (ApiException $e) {
            $transaction->setStatus(TransactionStatus::FAILED);
            return new TransactionResult(false, 'Échec de la transaction: ' . $e->getMessage());
        }
    }

    /**
     * Annule une transaction avec Square
     */
    public function cancelTransaction(Transaction $transaction): TransactionResult {
        try {
            $amountMoney = new Money();
            $amountMoney->setAmount(intval($transaction->getAmount() * 100));
            $amountMoney->setCurrency($transaction->getCurrency());

            $idempotencyKey = uniqid();
            $tenderId = $transaction->getTransactionId();

            $refundRequest = new CreateRefundRequest($idempotencyKey, $tenderId, $amountMoney);

            $refund = $this->client->getRefundsApi()->refundPayment($refundRequest);
            $transaction->setStatus(TransactionStatus::CANCELLED);
            return new TransactionResult(true, 'Annulation réussie: ' . $refund->getResult()->getId());
        } catch (ApiException $e) {
            return new TransactionResult(false, 'Échec de l\'annulation: ' . $e->getMessage());
        }
    }

    /**
     * Récupère le statut d'une transaction Square
     */
    public function getTransactionStatus(Transaction $transaction): string {
        try {
            $payment = $this->client->getPaymentsApi()->getPayment($transaction->getTransactionId());
            switch ($payment->getResult()->getStatus()) {
                case 'COMPLETED':
                    return TransactionStatus::SUCCESS;
                case 'PENDING':
                    return TransactionStatus::PENDING;
                case 'REFUNDED':
                    return TransactionStatus::REFUNDED;
                default:
                    return TransactionStatus::FAILED;
            }
        } catch (ApiException $e) {
            return TransactionStatus::FAILED;
        }
    }
}
