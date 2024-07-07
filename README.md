# PatternPay Library

PatternPay est une librairie PHP conçue pour faciliter l'intégration et la gestion des paiements dans vos applications. Elle supporte plusieurs passerelles de paiement grâce à l'utilisation de design patterns tels que Strategy, Factory, Observer, Adapter, et State.

## Fonctionnalités

- **Support de multiples passerelles de paiement** : Intégrez facilement différentes passerelles de paiement comme Stripe, ou Paypal.
- **Extensible** : Ajoutez de nouvelles passerelles de paiement sans modifier le code existant.
- **Notifications** : Recevez des notifications sur les transactions grâce au pattern Observer.

## Design Patterns Utilisés

- **Strategy** : Permet de changer la stratégie de paiement à l'exécution. Chaque passerelle de paiement implémente l'interface `PaymentGatewayInterface`, permettant au `PaymentManager` de les utiliser de manière interchangeable.
- **Factory** : Utilisé pour créer des objets sans spécifier la classe concrète. `TransactionFactory` peut être utilisé pour créer des transactions.
- **Observer** : Permet d'envoyer des notifications lors des changements d'état des transactions. `EmailNotificationObserver` est un exemple d'observateur qui envoie des emails lors des mises à jour des transactions.
- **Adapter** : Permet d'intégrer des bibliothèques tierces sans changer l'interface principale. Par exemple, l'intégration de `PHPMailer` pour l'envoi d'emails.
- **State** : Gère les différents états d'une transaction (par exemple, réussie, échouée, en attente).

## Mise en Place

### Prérequis

- PHP 8 ou supérieur
- Composer
- Compte Stripe ou Square ou autre
- Compte mailtrap pour recevoir les notifications

### Installation

1. Ajoutez PatternPay à votre projet via Composer :

```sh
composer require mijos/pattern-pay
```

2. Utilisez Composer pour charger les dépendances :

```php
require_once __DIR__ . './vendor/autoload.php';
```

### Configuration

1. Initialisation du PaymentManager :

```php
use PatternPay\PaymentManager;
$paymentManager = new PaymentManager();
```

2. Ajout des observateurs

```php
use PatternPay\Observers\EmailNotificationObserver;
use PHPMailer\PHPMailer\PHPMailer;

$phpmailer = new PHPMailer(true);
// Configuration de PHPMailer...
$paymentManager->addObserver(new EmailNotificationObserver($phpmailer, 'recipient@example.com'));
```

3. Ajout et configuration des passerelles de paiement :

```php
use PatternPay\Gateways\StripeGateway;

$stripeGateway = new StripeGateway();
$stripeGateway->initialize(['api_key' => 'votre_clé_api_stripe']);
$paymentManager->addGateway('stripe', $stripeGateway);
```

## Etape à faire pour tester le projet (pour le prof)
1. Installer les dépendances 
```sh
composer install
```
2. Lancer le serveur php
```sh
php -S localhost:8000
```
3. Une fois sur l'interface graphique, renseigner le montant, la devise et la description de la transaction. (La transaction sera validé puis annulé directement par la suite pour tester le fonctionnement de l'annulation d'une transaction)

![Interface graphique](interface.png)

4. Si une réelle clé Stripe a été mise, vous pouvez vérifier l'état de la transaction dans le menu "Transaction" de votre tableau de bord Stripe

![Tableau de bord Stripe](stripe.png)

## Conclusion
PatternPay offre une solution  extensible pour l'intégration de paiements dans vos applications PHP.
