<?php
require_once '../vendor/autoload.php';

use PaymentManager\PaymentManager;
use PaymentGateway\StripeGateway;
use PaymentGateway\PayPalGateway;

$manager = new PaymentManager();

// Initialisation des passerelles
$stripe = new StripeGateway();
$stripe->initialize(['api_key' => 'your_stripe_api_key']);
$manager->addGateway('stripe', $stripe);

$paypal = new PayPalGateway();
$paypal->initialize(['client_id' => 'your_paypal_client_id', 'client_secret' => 'your_paypal_client_secret']);
$manager->addGateway('paypal', $paypal);

// Création et exécution d'une transaction avec Stripe
$transaction = $manager->createTransaction('stripe', 100.0, 'USD', 'Test payment');
$result = $manager->executeTransaction('stripe', $transaction);
echo "Transaction status: " . $result;

// Vous pouvez répéter la même chose pour PayPal ou d'autres passerelles ajoutées
