<?php

namespace PatternPay\Observers;

use PatternPay\Interfaces\TransactionObserverInterface;
use PatternPay\Transactions\Transaction;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class EmailNotificationObserver
 * @package PatternPay\Observers
 */
class EmailNotificationObserver implements TransactionObserverInterface {
    private $mailer;
    private $recipientEmail;

    public function __construct(PHPMailer $mailer, string $recipientEmail) {
        $this->mailer = $mailer;
        $this->recipientEmail = $recipientEmail;
    }

    // Mise à jour d'une transaction à partir d'une transaction 
    public function update(Transaction $transaction): void {
        $status = $transaction->getStatus();
        $message = "Transaction " . $transaction->getTransactionId() . " status updated to " . $status;

        // Envoi d'un e-mail de notification à l'utilisateur 
        try {
            $this->mailer->setFrom('no-reply@yourdomain.com', 'Your App Name');
            $this->mailer->addAddress($this->recipientEmail);
            $this->mailer->Subject = 'Transaction Status Update';
            $this->mailer->Body    = $message;

            $this->mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
