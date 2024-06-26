<?php
use PHPUnit\Framework\TestCase;
use PaymentManager\PaymentManager;
use PaymentGateway\PaymentGatewayInterface;

class PaymentManagerTest extends TestCase {
    public function testAddGateway() {
        $manager = new PaymentManager();
        $gateway = $this->createMock(PaymentGatewayInterface::class);
        $manager->addGateway('test', $gateway);
        $this->assertInstanceOf(PaymentGatewayInterface::class, $manager->getGateway('test'));
    }

    // Ajoutez d'autres tests pour les méthodes de PaymentManager
}
