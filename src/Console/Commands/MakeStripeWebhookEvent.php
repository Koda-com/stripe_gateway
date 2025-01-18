<?php

namespace kodastripe\StripeWebhook\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeStripeWebhookEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:make-event {name : O nome do evento}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um novo evento Stripe Webhook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Events/{$name}.php");

        if (File::exists($path)) {
            $this->error("O evento {$name} já existe!");
            return Command::FAILURE;
        }

        $stub = $this->getStub();
        $content = str_replace('{{ class }}', $name, $stub);

        File::ensureDirectoryExists(app_path('Events'));
        File::put($path, $content);

        $this->info("Evento {$name} criado com sucesso em app/Events!");

        return Command::SUCCESS;
    }

    /**
     * Obtém o conteúdo do stub do evento.
     *
     * @return string
     */
    protected function getStub()
    {
        return <<<'STUB'
        <?php

        namespace App\Events;

        class {{ class }}
        {
            public $webhookEvent;

            /**
             * Cria uma nova instância de evento.
             */
            public function __construct($webhookEvent)
            {
                $this->webhookEvent = $webhookEvent;
            }
        }
        STUB;
    }
}