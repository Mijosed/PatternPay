<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;
/**
 * Interface TransactionFactory
 * @package PatternPay\Interfaces
 */
interface TransactionFactory {

    // Création d'une transaction à partir d'un montant, d'une devise et d'une description 
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
}
