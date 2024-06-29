<?php

namespace PatternPay\Transactions;

class TransactionStatus {
    const PENDING = 'pending';
    const SUCCESS = 'success';
    const FAILED = 'failed';
    const CANCELLED = 'cancelled';
    const REFUNDED = 'refunded';
    
    // Méthode pour vérifier si une valeur est un statut valide
    public static function isValidStatus(string $status): bool {
        $statuses = [
            self::PENDING,
            self::SUCCESS,
            self::FAILED,
            self::CANCELLED,
            self::REFUNDED
        ];
        
        return in_array($status, $statuses, true);
    }
}
