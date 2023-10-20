<?php

namespace EightyNine\ExcelImport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EightyNine\ExcelImportAction\ExcelImportAction
 */
class ExcelImportAction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EightyNine\ExcelImportAction\ExcelImportAction::class;
    }
}
