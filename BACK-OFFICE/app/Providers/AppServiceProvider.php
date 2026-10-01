<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            ServeCommand::$passthroughVariables = array_values(array_unique(array_merge(
                ServeCommand::$passthroughVariables,
                [
                    'SystemRoot',
                    'SYSTEMROOT',
                    'SystemDrive',
                    'windir',
                    'WINDIR',
                    'ComSpec',
                    'COMSPEC',
                    'PATHEXT',
                    'TMP',
                    'TEMP',
                    'USERPROFILE',
                    'HOMEDRIVE',
                    'HOMEPATH',
                    'APPDATA',
                    'LOCALAPPDATA',
                    'ProgramData',
                    'ProgramFiles',
                    'ProgramFiles(x86)',
                ]
            )));
        }
    }
}
