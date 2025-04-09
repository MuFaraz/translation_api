<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;

class GenerateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dummy translations for testing performance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating 100k+ translations');

        Translation::factory()->count(100000)->create();

        $this->info('Done!');
    }
}
