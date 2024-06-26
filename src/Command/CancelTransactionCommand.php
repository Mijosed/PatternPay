<?php
namespace designpattern/pattern-pay/Command;

use PaymentGateway\PaymentGatewayInterface;

class CancelTransactionCommand {
    private $gateway;
    private $transaction;

    public function __construct(PaymentGatewayInterface $gateway, $transaction) {
        $this->gateway = $gateway;
        $this->transaction = $transaction;
    }

    public function execute() {
        return $this->gateway->cancelTransaction($this->transaction);
    }
}
