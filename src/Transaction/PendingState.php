namespace Transaction;

class PendingState implements TransactionState {
    private $transaction;

    public function __construct($transaction) {
        $this->transaction = $transaction;
    }

    public function cancel() {
        // Logic to cancel the transaction
        $this->transaction->setState(new CanceledState($this->transaction));
    }
}
