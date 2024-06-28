<?php

require_once __DIR__ . './vendor/autoload.php';
use PatternPay\PaymentManager;
use PatternPay\Gateways\StripeGateway;

// Création du gestionnaire de paiement
$paymentManager = new PaymentManager();

try {
    // Ajout de Stripe
    $stripeGateway = new StripeGateway();
    $stripeGateway->initialize(['api_key' => 'sk_test_51PQtwjCg9Drn5vsL42h9um7osBfE2IMlp7qOHHNx32myT9FTSpOahsQ4EKlyOsIfG2DRjMVyCwNYhdClIleZMS7q00TRF5feKU']);
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
