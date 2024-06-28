<?php

require_once __DIR__ . '/vendor/autoload.php';
use PatternPay\PaymentManager;
use PatternPay\Gateways\StripeGateway;

// Création du gestionnaire de paiement
$paymentManager = new PaymentManager();

try {
    // Ajout de Stripe
    $stripeGateway = new StripeGateway();
    $stripeGateway->initialize(['api_key' => 'sk_test_51PQtwjCg9Drn5vsL42h9um7osBfE2IMlp7qOHHNx32myT9FTSpOahsQ4EKlyOsIfG2DRjMVyCwNYhdClIleZMS7q00TRF5feKU']);
    $paymentManager->addGateway('stripe', $stripeGateway);

    // Création de la transaction
    $transaction = $paymentManager->createTransaction('stripe', 100.00, 'USD', 'Payment description');

    // Exécution de la transaction
    $result = $paymentManager->executeTransaction('stripe', $transaction);
    echo "Transaction Message: " . $result->getMessage() . "\n";

    // Annulation de la transaction
    $cancelResult = $paymentManager->cancelTransaction('stripe', $transaction);
    echo "Cancellation Message: " . $cancelResult->getMessage() . "\n";

    // Récupération du statut après l'exécution
    $statusAfterExecution = $paymentManager->getTransactionStatus('stripe', $transaction);
    echo "Transaction Status after execution: " . $statusAfterExecution . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
