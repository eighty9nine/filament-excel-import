<?php

use EightyNine\ExcelImport\EnhancedDefaultImport;
use EightyNine\ExcelImport\Exceptions\ImportStoppedException;
use Illuminate\Support\Collection;

it('can stop import with error message', function () {
    $import = new class ('TestModel') extends EnhancedDefaultImport {
        protected function beforeCollection(Collection $collection): void
        {
            $this->stopImportWithError('Test error message');
        }
    };

    $collection = collect([
        collect(['name' => 'John', 'email' => 'john@example.com']),
    ]);

    expect(fn() => $import->collection($collection))
        ->toThrow(ImportStoppedException::class, 'Test error message');
});

it('can validate headers and stop import', function () {
    $import = new class ('TestModel') extends EnhancedDefaultImport {
        protected function beforeCollection(Collection $collection): void
        {
            $this->validateHeaders(['name', 'email', 'phone'], $collection);
        }
    };

    $collection = collect([
        collect(['name' => 'John', 'email' => 'john@example.com']), // missing 'phone'
    ]);

    expect(fn() => $import->collection($collection))
        ->toThrow(ImportStoppedException::class);
});

it('can stop import with different message types', function () {
    $import = new class ('TestModel') extends EnhancedDefaultImport {
        public function testStopWithWarning(): void
        {
            $this->stopImportWithWarning('Warning message');
        }

        public function testStopWithInfo(): void
        {
            $this->stopImportWithInfo('Info message');
        }

        public function testStopWithSuccess(): void
        {
            $this->stopImportWithSuccess('Success message');
        }
    };

    expect(fn() => $import->testStopWithWarning())
        ->toThrow(ImportStoppedException::class, 'Warning message');

    expect(fn() => $import->testStopWithInfo())
        ->toThrow(ImportStoppedException::class, 'Info message');

    expect(fn() => $import->testStopWithSuccess())
        ->toThrow(ImportStoppedException::class, 'Success message');
});
