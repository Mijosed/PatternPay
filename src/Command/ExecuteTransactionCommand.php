<?php
namespace Command;

use PaymentGateway\PaymentGatewayInterface;

class ExecuteTransactionCommand {
    private $gateway;
    private $transaction;

    public function __construct(PaymentGatewayInterface $gateway, $transaction) {
        $this->gateway = $gateway;
        $this->transaction = $transaction;
    }

    public function execute() {
        return $this->gateway->executeTransaction($this->transaction);
    }
}
