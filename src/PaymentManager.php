<?php

namespace PatternPay;

use PatternPay\Interfaces\PaymentGatewayInterface;

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
}
