<?php

namespace PatternPay;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Interfaces\TransactionObserverInterface;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;

class PaymentManager {
    private $gateways = [];
    private $observers = [];

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
            $result = $this->gateways[$gatewayName]->executeTransaction($transaction);
            $this->notifyObservers($transaction);
            return $result;
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    public function cancelTransaction(string $gatewayName, Transaction $transaction): TransactionResult {
        if (isset($this->gateways[$gatewayName])) {
            $result = $this->gateways[$gatewayName]->cancelTransaction($transaction);
            $this->notifyObservers($transaction);
            return $result;
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

    public function addObserver(TransactionObserverInterface $observer): void {
        $this->observers[] = $observer;
    }

    private function notifyObservers(Transaction $transaction): void {
        foreach ($this->observers as $observer) {
            $observer->update($transaction);
        }
    }
}
