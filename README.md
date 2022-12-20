# Laravel CinetPay #

### Installation

```text
composer require zampou/cinetpay
```

### 1. Installation du Service Provider
Tous les fournisseurs de services sont enregistrés dans le fichier de configuration suivant `config/app.php`.
```php
'providers' => [
    /*
    * Package Service Providers...
    */
    Zampou\CinetPay\Providers\CinetPayProvider::class,
],
```

### 2. Configurer
Configuration du fichier `.env`

```text
CINETPAY_SITE_ID=votre_site_id
CINETPAY_API_KEY=votre_cle_api
```

*Exécutez `php artisan vendor:publish --provider="Zampou\CinetPay\Providers\CinetPayProvider" --tag="cinetpay"` pour le fichier de configuration complet.*

Config : `config/cinetpay.php`

```php
return [
    'CINETPAY_API_KEY' => env('CINETPAY_API_KEY'),
    'CINETPAY_SITE_ID' =>  env('CINETPAY_SITE_ID')
];
```


### 3. IPN et CSRF Token
Désactiver la vérification CSRF sur la route ipn de CinetPay, toutes les routes excluent sont dans le fichier suivant `app/Http/Middleware/VerifyCsrfToken.php`.

```php
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/cinetpay-ipn'
    ];
```


### 4. Usage

Cree une transaction

```php
use Zampou\CinetPay\Facades\CinetPay;

$transactionLink = CinetPay::generatePaymentLink([
    'amount' => '100',
    'currency' => 'XOF',
    'customer_name' => 'John',
    'customer_surname' => 'Doe',
    'transaction_id' => '123456789',
    'description' => 'Bon gbozon bien chaud de qualité',
]);

dd($transactionLink);
```


#### validation IPN

Laravel CinetPay peut gérer automatiquement les IPN pour vous :
Il suffit simplement à s'abonner à l'événement` Zampou\CinetPay\Events\CinetPayIPN` en creant en Listener avec la commande suivant :

```text
php artisan make:listener CinetPayIPNListener
``` 

Il suffit ensuite de s'abonner à l'événement en ajoutant un écouteur au `App\Providers\EventServiceProvider` :

```php
    use App\Listeners\CinetPayIpnListener;
    use Zampou\CinetPay\Events\CinetPayIPN;
    // ...

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        CinetPayIPN::class => [
            CinetPayIpnListener::class
        ]
    ];
```

Exemple de Listener d'événements :

```php
<?php

namespace App\Listeners;

class CinetPayIpnListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Vous faite votre traitement ici
        // Structure des données dans la variable `payment_data`
        // [
        //     'code',
        //     'message',
        //     'amount',
        //     'metadata',
        //     'currency',
        //     'operator_id',
        //     'description',
        //     'payment_date',
        //     'payment_method'
        //     'api_response_id',
        // ]

        dd($event->payment_data);
    }
}
```