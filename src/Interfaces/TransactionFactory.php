<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;

interface TransactionFactory {
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
}
