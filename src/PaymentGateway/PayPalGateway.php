<?php
namespace PaymentGateway;

class PayPalGateway extends AbstractPaymentGateway {
    public function createTransaction(float $amount, string $currency, string $description) {
        // Implémentation spécifique à PayPal
    }

    public function executeTransaction($transaction) {
        // Implémentation spécifique à PayPal
    }

    public function cancelTransaction($transaction) {
        // Implémentation spécifique à PayPal
    }

    public function getStatus($transaction) {
        // Implémentation spécifique à PayPal
    }
}
