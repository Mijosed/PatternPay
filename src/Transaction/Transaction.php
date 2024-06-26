namespace Transaction;

class Transaction {
    private $state;

    public function __construct(TransactionState $state) {
        $this->state = $state;
    }

    public function setState(TransactionState $state) {
        $this->state = $state;
    }

    public function cancel() {
        $this->state->cancel();
    }
}
