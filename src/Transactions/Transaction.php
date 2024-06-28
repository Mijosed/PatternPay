<?php

namespace PatternPay\Transactions;

class Transaction {
    private $amount;
    private $currency;
    private $description;
    private $status;
    private $transactionId;

    public function __construct(float $amount, string $currency, string $description) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->status = TransactionStatus::PENDING;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getCurrency(): string {
        return $this->currency;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        if (!in_array($status, [TransactionStatus::PENDING, TransactionStatus::SUCCESS, TransactionStatus::FAILED, TransactionStatus::CANCELLED])) {
            throw new \InvalidArgumentException("Invalid transaction status: $status");
        }
        $this->status = $status;
    }

    public function getTransactionId(): ?string {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void {
        $this->transactionId = $transactionId;
    }
}
