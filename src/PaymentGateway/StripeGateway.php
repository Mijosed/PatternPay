<?php
namespace PaymentGateway;

class StripeGateway extends AbstractPaymentGateway {
    public function createTransaction(float $amount, string $currency, string $description) {
        // Implémentation spécifique à Stripe
    }

    public function executeTransaction($transaction) {
        // Implémentation spécifique à Stripe
    }

    public function cancelTransaction($transaction) {
        // Implémentation spécifique à Stripe
    }

    public function getStatus($transaction) {
        // Implémentation spécifique à Stripe
    }
}
