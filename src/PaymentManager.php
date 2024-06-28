<?php

namespace PatternPay;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Interfaces\TransactionFactory;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;

class PaymentManager {
    private $gateways = [];

    public function addGateway(string $name, PaymentGatewayInterface $gateway): void {
        $this->gateways[$name] = $gateway;
    }

    public function getGateway(string $name): ?PaymentGatewayInterface {
        return $this->gateways[$name] ?? null;
    }

    public function removeGateway(string $name): void {
        unset($this->gateways[$name]);
    }

    public function executeTransaction(string $gatewayName, Transaction $transaction): TransactionResult {
        if (isset($this->gateways[$gatewayName])) {
            return $this->gateways[$gatewayName]->executeTransaction($transaction);
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    public function cancelTransaction(string $gatewayName, Transaction $transaction): TransactionResult {
        if (isset($this->gateways[$gatewayName])) {
            return $this->gateways[$gatewayName]->cancelTransaction($transaction);
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    public function getTransactionStatus(string $gatewayName, Transaction $transaction): string {
        if (isset($this->gateways[$gatewayName])) {
            return $this->gateways[$gatewayName]->getTransactionStatus($transaction);
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }
    public function createTransaction(string $gatewayName, float $amount, string $currency, string $description): Transaction {
        $gateway = $this->getGateway($gatewayName);
        if ($gateway instanceof TransactionFactory) {
            return $gateway->createTransaction($amount, $currency, $description);
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' does not support transaction creation.");
        }
    }
}
