<?php

require_once __DIR__ . './vendor/autoload.php';

use PatternPay\PaymentManager;
use PatternPay\Gateways\StripeGateway;
use PatternPay\Observers\EmailNotificationObserver;
use PHPMailer\PHPMailer\PHPMailer;

$phpmailer = new PHPMailer(true);
$phpmailer->isSMTP();
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = 'username';
$phpmailer->Password = 'password';

// Création du gestionnaire de paiement
$paymentManager = new PaymentManager();

// Ajout des observateurs
$paymentManager->addObserver(new EmailNotificationObserver($phpmailer, 'recipient@example.com'));

try {
    // Ajout de Stripe
    $stripeGateway = new StripeGateway();
    $stripeGateway->initialize(['api_key' => 'sk_test_51PQtwjCg9Drn5vsL42h9um7osBfE2IMlp7qOHHNx32myT9FTSpOahsQ4EKlyOsIfG2DRjMVyCwNYhdClIleZMS7q00TRF5feKU']);
    $paymentManager->addGateway('stripe', $stripeGateway);

    // Créer et exécution de la transaction
    $transaction = $stripeGateway->createTransaction(100.00, 'USD', 'Payment description');

    $result = $paymentManager->executeTransaction('stripe', $transaction);
    echo "Transaction Message: " . $result->getMessage() . "\n";

    // Annulation de la transaction
    $cancelResult = $paymentManager->cancelTransaction('stripe', $transaction);
    $statusAfterExecution = $paymentManager->getTransactionStatus('stripe', $transaction);
    echo "Transaction Status after execution: " . $statusAfterExecution . "\n";
    echo "Cancellation Message: " . $cancelResult->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
