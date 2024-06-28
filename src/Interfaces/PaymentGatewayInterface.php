<?php

namespace Mijos\PatternPay\Interfaces;

use Mijos\PatternPay\Transactions\Transaction;
use Mijos\PatternPay\Transactions\TransactionResult;

interface PaymentGatewayInterface {
    public function initialize(array $config): void;
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
    public function executeTransaction(Transaction $transaction): TransactionResult;
    public function cancelTransaction(Transaction $transaction): TransactionResult;
    public function getTransactionStatus(Transaction $transaction): string;
}
