<?php
namespace SleepingOwl\Framework\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use SleepingOwl\Framework\Console\Installation;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class InstallCommand extends Command
{
    use ConfirmableTrait;

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
     * @param SleepingOwl $framework
     *
     * @return mixed
     */
    public function handle(SleepingOwl $framework)
    {
        if (! defined('SLEEPINGOWL_STUB_PATH')) {
            define('SLEEPINGOWL_STUB_PATH', SLEEPINGOWL_PATH.'/install-stubs');
        }

        if (! $this->confirmToProceed($framework->longName())) {
            return;
        }

        $installers = collect([
            Installation\InstallMigrations::class,
            Installation\CreateRootUser::class,
            Installation\InstallConfiguration::class,
            Installation\InstallAssets::class,
        ]);

        $installers
        ->map(function($installer) {
            return new $installer($this);
        })
        ->filter(function($installer) {
            return ! $installer->installed();
        })->each(function ($installer) {
            $installer->install();
            $installer->showInfo();
        });

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
