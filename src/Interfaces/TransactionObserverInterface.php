<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;

/**
 * Interface TransactionObserverInterface
 * @package PatternPay\Interfaces
 */
interface TransactionObserverInterface {
    // Mise à jour d'une transaction à partir d'une transaction 
    public function update(Transaction $transaction): void;
}
