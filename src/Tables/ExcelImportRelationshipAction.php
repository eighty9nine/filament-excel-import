<?php

namespace EightyNine\ExcelImport\Tables;

use Closure;
use EightyNine\ExcelImport\Concerns\HasExcelImportAction;
use EightyNine\ExcelImport\DefaultRelationshipImport;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportRelationshipAction extends Action
{
    use HasExcelImportAction;

    protected string $importClass = DefaultRelationshipImport::class;

    private function importData(): Closure
    {
        return function (array $data, $livewire): bool {
            if (is_callable($this->beforeImportClosure)) {
                call_user_func($this->beforeImportClosure, $data, $livewire, $this);
            }

            $importObject = new $this->importClass(
                method_exists($this, 'getModel') ? $this->getModel() : null,
                $this->importClassAttributes,
                $this->additionalData,
                method_exists($livewire, 'getOwnerRecord') ? $livewire->getOwnerRecord() : null,
                method_exists($livewire, 'getRelationship') ? $livewire->getRelationship() : null,
                method_exists($livewire, 'getTable') ? $livewire->getTable() : null
            );

            if (method_exists($importObject, 'setAdditionalData') && isset($this->additionalData)) {
                $importObject->setAdditionalData($this->additionalData);
            }

            if (method_exists($importObject, 'setCustomImportData') && isset($this->customImportData)) {
                $importObject->setCustomImportData($this->customImportData);
            }

            if (method_exists($importObject, 'setCollectionMethod') && isset($this->collectionMethod)) {
                $importObject->setCollectionMethod($this->collectionMethod);
            }

            if (method_exists($importObject, 'setAfterValidationMutator') &&
               (isset($this->afterValidationMutator) || $this->shouldRetainBeforeValidationMutation)) {
                $afterValidationMutator = $this->shouldRetainBeforeValidationMutation ?
                        $this->beforeValidationMutator :
                        $this->afterValidationMutator;
                $importObject->setAfterValidationMutator($afterValidationMutator);
            }

            try {
                Excel::import($importObject, $data['upload']);

                if (is_callable($this->afterImportClosure)) {
                    call_user_func($this->afterImportClosure, $data, $livewire);
                }

                return true;
            } catch (\EightyNine\ExcelImport\Exceptions\ImportStoppedException $e) {
                // Handle stopped import with user message
                $notification = match ($e->getType()) {
                    'warning' => \Filament\Notifications\Notification::make()
                        ->warning()
                        ->title(__('excel-import::excel-import.import_warning'))
                        ->body($e->getUserMessage()),
                    'info' => \Filament\Notifications\Notification::make()
                        ->info()
                        ->title(__('excel-import::excel-import.import_information'))
                        ->body($e->getUserMessage()),
                    'success' => \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('excel-import::excel-import.import_success'))
                        ->body($e->getUserMessage()),
                    default => \Filament\Notifications\Notification::make()
                        ->danger()
                        ->title(__('excel-import::excel-import.import_failed'))
                        ->body($e->getUserMessage()),
                };

                $notification->send();
                
                return false;
            }
        };
    }
}
