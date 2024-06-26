<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mijos\PatternPay\PaymentManager;
use Mijos\PatternPay\Gateways\StripeGateway;
use Mijos\PatternPay\Transactions\TransactionStatus;

// Création du gestionnaire de paiement
$paymentManager = new PaymentManager();

// Ajout de Stripe
$stripeGateway = new StripeGateway();
$stripeGateway->initialize(['apiKey' => 'sk_test_51PW1WvJFP4C1ZqxZY7XbvSvZ2rN0h9eFrTc5R5MSg1Lgd1IiFVmGpP9MsWd0zTgBvLeIKMG6d595OZci6Q57lJm5003oNMCTpB']);
$paymentManager->addGateway('stripe', $stripeGateway);

// Créer et exécution de la transaction
$transaction = $stripeGateway->createTransaction(100.00, 'USD', 'Payment description');
$result = $stripeGateway->executeTransaction($transaction);

echo "Transaction Status: " . $result->getStatus() . "\n";  

// Annulation de la transaction
$cancelResult = $stripeGateway->cancelTransaction($transaction);

echo "Transaction Status after cancellation: " . $cancelResult->getStatus() . "\n";  
