<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;

/**
 * Interface PaymentGatewayInterface
 * @package PatternPay\Interfaces
 */
interface PaymentGatewayInterface {
    // Initialisation de la passerelle de paiement 
    public function initialize(array $config): void;

    // Création d'une transaction à partir d'un montant, d'une devise et d'une description 
    public function createTransaction(float $amount, string $currency, string $description): Transaction;

    // Exécution d'une transaction à partir d'une transaction 
    public function executeTransaction(Transaction $transaction): TransactionResult;

    // Annulation d'une transaction à partir d'une transaction
    public function cancelTransaction(Transaction $transaction): TransactionResult; 

    // Récupération du statut d'une transaction à partir d'une transaction 
    public function getTransactionStatus(Transaction $transaction): string;
}
