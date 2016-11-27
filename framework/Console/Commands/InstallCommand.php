<?php
namespace SleepingOwl\Framework\Console\Commands;

use Illuminate\Console\Command;
use SleepingOwl\Framework\Console\Installation;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sleepingowl:install
                    {--force : Force SleepingOwl to install even it has been already installed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the SleepingOwl scaffolding into the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! defined('SLEEPINGOWL_STUB_PATH')) {
            define('SLEEPINGOWL_STUB_PATH', SLEEPINGOWL_PATH.'/install-stubs');
        }

        if ($this->alreadyInstalled() && ! $this->option('force')) {
            return $this->line('SleepingOwl is already installed for this project.');
        }

        $installers = collect([
            Installation\InstallConfiguration::class,
        ]);

        $installers->each(function ($installer) { (new $installer($this))->install(); });

        $this->comment('SleepingOwl Framework installed.');
    }

    /**
     * Determine if Spark is already installed.
     *
     * @return bool
     */
    protected function alreadyInstalled(): bool
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        return isset($composer['require']['sleepingowl/framework']);
    }
}
