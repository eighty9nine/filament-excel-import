<?php

namespace EightyNine\ExcelImport\Commands;

use Illuminate\Console\Command;

class ExcelImportActionCommand extends Command
{
    public $signature = 'filament-excel-import';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
