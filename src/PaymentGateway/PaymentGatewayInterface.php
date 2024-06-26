<?php

namespace PaymentGateway;

interface PaymentGatewayInterface {
    public function initialize(array $config): void;
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
    public function executeTransaction(Transaction $transaction): TransactionResult;
    public function cancelTransaction(Transaction $transaction): bool;
    public function getTransactionStatus(Transaction $transaction): string;
}
