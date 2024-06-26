<?php
require 'vendor/autoload.php';

use PaymentGateway\Stripe\StripeGateway;

// Initialisation de la passerelle Stripe avec les identifiants de connexion
$stripe = new StripeGateway();
$stripe->initialize(['api_key' => 'pk_test_51PQtwjCg9Drn5vsLCF8lJgTkr3leTDjWHvKjoxLKyUBxaMldWC3oRJZuvTKWdgHBWHn2crNaeiyaLhKWT6FhCg0l00MuziEpIn']);

// Création d'une transaction
$transaction = $stripe->createTransaction(100.0, 'USD', 'Test transaction');

// Exécution de la transaction
$result = $stripe->executeTransaction($transaction);

// Affichage du résultat
if ($result->isSuccess()) {
    echo "Paiement réussi : " . $result->getMessage();
} else {
    echo "Échec du paiement : " . $result->getMessage();
}
