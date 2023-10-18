<?php

namespace EightyNine\ExcelImportAction;

use Filament\Contracts\Plugin;
use Filament\Panel;

class ExcelImportActionPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-excel-import';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
