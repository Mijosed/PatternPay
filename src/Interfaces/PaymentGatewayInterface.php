<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;

interface PaymentGatewayInterface {
    public function initialize(array $config): void;
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
    public function executeTransaction(Transaction $transaction): TransactionResult;
    public function cancelTransaction(Transaction $transaction): TransactionResult; 
    public function getTransactionStatus(Transaction $transaction): string;
}
