<?php
namespace PaymentGateway;

abstract class AbstractPaymentGateway implements PaymentGatewayInterface {
    protected $config;

    public function initialize(array $config) {
        $this->config = $config;
    }

    // Méthodes communes peuvent être ajoutées ici
}
