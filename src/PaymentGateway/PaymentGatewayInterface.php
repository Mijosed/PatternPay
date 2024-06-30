<?php

namespace PaymentGateway;
/**
 * Interface PaymentGatewayInterface
 * @package PaymentGateway
 */
interface PaymentGatewayInterface {
    // Initialisation de la passerelle de paiement avec une configuration spécifique (par exemple, clé API, URL de l'API, etc.)
    public function initialize(array $config): void;

    // Création d'une transaction à partir des détails fournis (montant, devise, description) et retour de l'objet Transaction créé 
    public function createTransaction(float $amount, string $currency, string $description): Transaction;

    // Exécution de la transaction en utilisant la passerelle de paiement et retour du résultat de la transaction (réussie ou échouée) avec un message de statut
    public function executeTransaction(Transaction $transaction): TransactionResult;

    // Annulation de la transaction et retour du statut de l'annulation (réussie ou échouée) 
    public function cancelTransaction(Transaction $transaction): bool;

    // Récupération du statut de la transaction et retour du statut de la transaction (réussie, échouée, en attente, etc.) 
    public function getTransactionStatus(Transaction $transaction): string;
}
