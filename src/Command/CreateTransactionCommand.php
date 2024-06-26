<?php
namespace Command;

use PaymentGateway\PaymentGatewayInterface;

class CreateTransactionCommand {
    private $gateway;
    private $amount;
    private $currency;
    private $description;

    public function __construct(PaymentGatewayInterface $gateway, float $amount, string $currency, string $description) {
        $this->gateway = $gateway;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
    }

    public function execute() {
        return $this->gateway->createTransaction($this->amount, $this->currency, $this->description);
    }
}
