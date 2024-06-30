<?php

namespace PaymentGateway;

/**
 * Représente le résultat d'une transaction de paiement.
 */
class TransactionResult {
    private bool $success;
    private string $message;

    // Initialisation du résultat de la transaction avec un indicateur de succès et un message associé 
    public function __construct(bool $success, string $message) {
        $this->success = $success;
        $this->message = $message;
    }

    // Récupération de l'indicateur de succès de la transaction
    public function isSuccess(): bool {
        return $this->success;
    }

    // Récupération du message associé à la transaction 
    public function getMessage(): string {
        return $this->message;
    }
}
