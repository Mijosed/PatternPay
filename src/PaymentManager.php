<?php
namespace PaymentManager;

use PaymentGateway\PaymentGatewayInterface;

class PaymentManager {
    private $gateways = [];

    public function addGateway(string $name, PaymentGatewayInterface $gateway) {
        $this->gateways[$name] = $gateway;
    }

    public function removeGateway(string $name) {
        unset($this->gateways[$name]);
    }

    public function getGateway(string $name): ?PaymentGatewayInterface {
        return $this->gateways[$name] ?? null;
    }

    public function createTransaction(string $gatewayName, float $amount, string $currency, string $description) {
        $gateway = $this->getGateway($gatewayName);
        if ($gateway) {
            return $gateway->createTransaction($amount, $currency, $description);
        }
        throw new Exception("Gateway not found");
    }

    public function executeTransaction(string $gatewayName, $transaction) {
        $gateway = $this->getGateway($gatewayName);
        if ($gateway) {
            return $gateway->executeTransaction($transaction);
        }
        throw new Exception("Gateway not found");
    }

    public function cancelTransaction(string $gatewayName, $transaction) {
        $gateway = $this->getGateway($gatewayName);
        if ($gateway) {
            return $gateway->cancelTransaction($transaction);
        }
        throw new Exception("Gateway not found");
    }

    public function getTransactionStatus(string $gatewayName, $transaction) {
        $gateway = $this->getGateway($gatewayName);
        if ($gateway) {
            return $gateway->getStatus($transaction);
        }
        throw new Exception("Gateway not found");
    }
}
