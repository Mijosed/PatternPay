# Pattern Pay Library

La librairie Pattern Pay est une solution de paiement PHP flexible et extensible, conçue pour intégrer facilement différents portails de paiement. Elle utilise des principes de conception avancés pour garantir une adaptabilité maximale aux divers besoins des développeurs. Cette documentation couvre le fonctionnement de la librairie et la manière de la mettre en place avec différents portails de paiement.

## Design Patterns Utilisés

Pattern Pay utilise plusieurs patrons de conception (design patterns) pour atteindre sa flexibilité et son extensibilité :

- **Strategy**: Permet de changer l'algorithme de paiement à l'exécution en fonction du portail de paiement choisi.
- **Factory**: Simplifie la création d'objets, comme les transactions ou les instances de portail de paiement, sans spécifier leur classe concrète.
- **Observer**: Utilisé pour notifier les composants intéressés du résultat d'une transaction.
- **Adapter**: Permet l'intégration de portails de paiement avec des interfaces différentes en uniformisant leur interaction avec la librairie.
- **State**: Gère les différents états d'une transaction (par exemple, en attente, réussie, échouée) et adapte son comportement en conséquence.

## Mise en Place

### Configuration

1. Installez la librairie via Composer :

```sh
composer require mijos/pattern-pay
```

2. Configurez l'autoload de Composer pour utiliser l'espace de noms PaymentGateway :

```php
"autoload": {
    "psr-4": {
        "PaymentGateway\\": "src/PaymentGateway/"
    }
}
```

## Utilisation avec Stripe

1. Initialisez le portail de paiement Stripe avec votre clé API :

```php
use PaymentGateway\Stripe\StripeGateway;

$stripe = new StripeGateway();
$stripe->initialize(['api_key' => 'sk_test_yourapikey']);
```

2. Créez une transaction :
```php
$transaction = $stripe->createTransaction(100.0, 'USD', 'Test transaction');
```

3. Exécutez la transaction :
```php
<?php
$result = $stripe->executeTransaction($transaction);
if ($result->isSuccess()) {
    echo "Paiement réussi : " . $result->getMessage();
} else {
    echo "Échec du paiement : " . $result->getMessage();
}
```

## Ajout de Nouveaux Portails de Paiement
Pour intégrer un nouveau portail de paiement, implémentez l'interface PaymentGatewayInterface et utilisez les design patterns mentionnés pour assurer la compatibilité et l'extensibilité.