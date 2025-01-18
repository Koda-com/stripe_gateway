
# Gateway Stripe

Biblioteca da Koda para implementação do gateway de pagamento "Stripe".


## Instalação

Instale com "composer"

```bash
composer require kodastripe/stripewebhook
```
Adicione o provider no arquivo "app.php"

```bash
\kodastripe\StripeWebhook\Providers\StripeWebhookServiceProvider::class
```
Receba o evento do WebHook e crie um listener

```bash
\kodastripe\StripeWebhook\Events\StripeWebhookReceived::class => [
   \App\Listeners\StripeWebhookReceivedListener::class
]
```
## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar adicionar as seguintes variáveis de ambiente no seu .env

`STRIPE_WEBHOOK_SECRET`


## Licença

[MIT](https://choosealicense.com/licenses/mit/)

