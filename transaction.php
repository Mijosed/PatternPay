<?php

require_once __DIR__ . '/vendor/autoload.php';

use PatternPay\PaymentManager;
use PatternPay\Gateways\StripeGateway;
use PatternPay\Observers\EmailNotificationObserver;
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];
    $description = $_POST['description'];

    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'd6242dbc8c22bb';
    $phpmailer->Password = '0f005a136d5588';

    // Création du gestionnaire de paiement
    $paymentManager = new PaymentManager();

    // Ajout des observateurs
    $paymentManager->addObserver(new EmailNotificationObserver($phpmailer, 'mijosed@gmail.com'));

    try {
        // Ajout de Stripe
        $stripeGateway = new StripeGateway();
        $stripeGateway->initialize(['api_key' => 'sk_test_51PW1WvJFP4C1ZqxZY7XbvSvZ2rN0h9eFrTc5R5MSg1Lgd1IiFVmGpP9MsWd0zTgBvLeIKMG6d595OZci6Q57lJm5003oNMCTpB']);
        $paymentManager->addGateway('stripe', $stripeGateway);

        // Créer et exécution de la transaction
        $transaction = $stripeGateway->createTransaction($amount, $currency, $description);

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
}