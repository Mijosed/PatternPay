<?php

use PHPUnit\Framework\TestCase;
use PaymentGateway\Stripe\StripeGateway;
use PaymentGateway\Transaction;

class StripeGatewayTest extends TestCase {
    public function testInitialize() {
        $gateway = new StripeGateway();
        $gateway->initialize(['api_key' => 'test_api_key']);
        $this->assertNotEmpty($gateway);
    }

    public function testCreateTransaction() {
        $gateway = new StripeGateway();
        $transaction = $gateway->createTransaction(100.0, 'USD', 'Test transaction');
        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals(100.0, $transaction->getAmount());
        $this->assertEquals('USD', $transaction->getCurrency());
        $this->assertEquals('Test transaction', $transaction->getDescription());
    }

    public function testExecuteTransaction() {
        $gateway = new StripeGateway();
        $transaction = new Transaction(100.0, 'USD', 'Test transaction');
        $result = $gateway->executeTransaction($transaction);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('Transaction successful', $result->getMessage());
    }

    // Add more tests for other methods
}
