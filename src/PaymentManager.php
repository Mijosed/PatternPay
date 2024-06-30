<?php

namespace PatternPay;

use PatternPay\Interfaces\PaymentGatewayInterface;
use PatternPay\Interfaces\TransactionObserverInterface;
use PatternPay\Transactions\Transaction;
use PatternPay\Transactions\TransactionResult;

/**
 * Class PaymentManager
 * @package PatternPay
 */
class PaymentManager {
    private $gateways = [];
    private $observers = [];

    // Ajout d'une passerelle de paiement 
    public function addGateway(string $name, PaymentGatewayInterface $gateway): void {
        $this->gateways[$name] = $gateway;
    }

    // Récupération d'une passerelle de paiement à partir de son nom 
    public function getGateway(string $name): ?PaymentGatewayInterface {
        return $this->gateways[$name] ?? null;
    }

    // Suppression d'une passerelle de paiement à partir de son nom 
    public function removeGateway(string $name): void {
        unset($this->gateways[$name]);
    }
    
    // Création d'une transaction à partir d'un montant, d'une devise et d'une description 
    public function executeTransaction(string $gatewayName, Transaction $transaction): TransactionResult {
        if (isset($this->gateways[$gatewayName])) {
            $result = $this->gateways[$gatewayName]->executeTransaction($transaction);
            $this->notifyObservers($transaction);
            return $result;
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    // Annulation d'une transaction à partir d'une transaction 
    public function cancelTransaction(string $gatewayName, Transaction $transaction): TransactionResult {
        if (isset($this->gateways[$gatewayName])) {
            $result = $this->gateways[$gatewayName]->cancelTransaction($transaction);
            $this->notifyObservers($transaction);
            return $result;
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    // Récupération du statut d'une transaction à partir d'une transaction 
    public function getTransactionStatus(string $gatewayName, Transaction $transaction): string {
        if (isset($this->gateways[$gatewayName])) {
            return $this->gateways[$gatewayName]->getTransactionStatus($transaction);
        } else {
            throw new \InvalidArgumentException("Gateway '$gatewayName' not found.");
        }
    }

    // Ajout d'un observateur de transaction 
    public function addObserver(TransactionObserverInterface $observer): void {
        $this->observers[] = $observer;
    }

    // Suppression d'un observateur de transaction 
    private function notifyObservers(Transaction $transaction): void {
        foreach ($this->observers as $observer) {
            $observer->update($transaction);
        }
    }
}
