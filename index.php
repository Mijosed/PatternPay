<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Mijos\PatternPay\PaymentManager;
use Mijos\PatternPay\Gateways\StripeGateway;

// Création du gestionnaire de paiement
$paymentManager = new PaymentManager();

try {
    // Ajout de Stripe
    $stripeGateway = new StripeGateway();
    $stripeGateway->initialize(['api_key' => 'sk_test_51PW1WvJFP4C1ZqxZY7XbvSvZ2rN0h9eFrTc5R5MSg1Lgd1IiFVmGpP9MsWd0zTgBvLeIKMG6d595OZci6Q57lJm5003oNMCTpB']);
    $paymentManager->addGateway('stripe', $stripeGateway);

    // Créer et exécution de la transaction
    $transaction = $stripeGateway->createTransaction(100.00, 'USD', 'Payment description');
    $result = $stripeGateway->executeTransaction($transaction);

    echo "Transaction Status: " . ($result->isSuccess() ? 'Success' : 'Failure') . "\n";
    echo "Transaction Message: " . $result->getMessage() . "\n";

    // Annulation de la transaction
    $cancelResult = $stripeGateway->cancelTransaction($transaction);
    echo "Transaction Cancellation Status: " . ($cancelResult->isSuccess() ? 'Success' : 'Failure') . "\n";
    echo "Cancellation Message: " . $cancelResult->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
