<?php

use Mijos\PatternPay\Gateways\StripeGateway;

require 'vendor/autoload.php';


try {
    // Initialisation de la passerelle Stripe avec les identifiants de connexion
    $stripe = new StripeGateway();
    $stripe->initialize(['api_key' => 'sk_test_51PQtwjCg9Drn5vsL42h9um7osBfE2IMlp7qOHHNx32myT9FTSpOahsQ4EKlyOsIfG2DRjMVyCwNYhdClIleZMS7q00TRF5feKU']);

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
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
