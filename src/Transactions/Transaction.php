<?php

namespace Mijos\PatternPay\Transactions;

class Transaction {
    private float $amount;
    private string $currency;
    private string $description;
    private string $status;

    public function __construct(float $amount, string $currency, string $description) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->status = 'pending';
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
        $this->status = $status;
    }
}
