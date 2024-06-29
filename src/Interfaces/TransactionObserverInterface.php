<?php

namespace PatternPay\Interfaces;

use PatternPay\Transactions\Transaction;

interface TransactionObserverInterface {
    public function update(Transaction $transaction): void;
}
