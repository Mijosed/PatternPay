<?php
namespace Transaction;

class CanceledState implements TransactionState {
    private $transaction;

    public function __construct($transaction) {
        $this->transaction = $transaction;
    }

    public function cancel() {
        throw new Exception("Transaction is already canceled.");
    }
}
