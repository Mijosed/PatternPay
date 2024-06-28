<?php

namespace PatternPay\Factories;

use PatternPay\Transactions\Transaction;

interface TransactionFactory {
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
}
