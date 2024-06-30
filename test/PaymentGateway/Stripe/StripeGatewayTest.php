<?php

use PHPUnit\Framework\TestCase;
use PaymentGateway\Stripe\StripeGateway;
use PaymentGateway\Transaction;

/**
 * Class StripeGatewayTest
 * Teste les fonctionnalités de la classe StripeGateway.
 */
class StripeGatewayTest extends TestCase {

    // Teste l'initialisation de la passerelle de paiement Stripe.
    public function testInitialize() {
        $gateway = new StripeGateway();
        $gateway->initialize(['api_key' => 'test_api_key']);
        $this->assertNotEmpty($gateway);
    }

    // Teste la création d'une transaction Stripe. 
    public function testCreateTransaction() {
        $gateway = new StripeGateway();
        $transaction = $gateway->createTransaction(100.0, 'USD', 'Test transaction');
        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals(100.0, $transaction->getAmount());
        $this->assertEquals('USD', $transaction->getCurrency());
        $this->assertEquals('Test transaction', $transaction->getDescription());
    }

    // Teste l'exécution d'une transaction Stripe.
    public function testExecuteTransaction() {
        $gateway = new StripeGateway();
        $transaction = new Transaction(100.0, 'USD', 'Test transaction');
        $result = $gateway->executeTransaction($transaction);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('Transaction successful', $result->getMessage());
    }

}
