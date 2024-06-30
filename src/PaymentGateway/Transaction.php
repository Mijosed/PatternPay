<?php

namespace PaymentGateway;

/**
 * Représente une transaction de paiement.
 */
class Transaction {
    private float $amount;
    private string $currency;
    private string $description;
    private string $status;

    // Initialisation de la transaction avec le montant, la devise et la description fournis et le statut par défaut "en attente" 
    public function __construct(float $amount, string $currency, string $description) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->status = 'pending';
    }

    // Récupération du montant de la transaction 
    public function getAmount(): float {
        return $this->amount;
    }

    // Récupération de la devise de la transaction 
    public function getCurrency(): string {
        return $this->currency;
    }

    // Récupération de la description de la transaction
    public function getDescription(): string {
        return $this->description;
    }

    // Récupération du statut de la transaction
    public function getStatus(): string {
        return $this->status;
    }

    // Définition du statut de la transaction 
    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
