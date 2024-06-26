<?php

namespace Mijos\PatternPay;

use Mijos\PatternPay\Interfaces\PaymentGatewayInterface;
use Mijos\PatternPay\Exceptions\PaymentException;

class PaymentManager {
    private $gateways = [];

    public function addGateway(string $name, PaymentGatewayInterface $gateway) {
        $this->gateways[$name] = $gateway;
    }

    public function removeGateway(string $name) {
        if (isset($this->gateways[$name])) {
            unset($this->gateways[$name]);
        } else {
            throw new PaymentException("Payment gateway not found: $name");
        }
    }

    public function getGateway(string $name): PaymentGatewayInterface {
        if (isset($this->gateways[$name])) {
            return $this->gateways[$name];
        } else {
            throw new PaymentException("Payment gateway not found: $name");
        }
    }
}
