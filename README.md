# Filament Excel Import

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eightynine/filament-excel-import.svg?style=flat-square)](https://packagist.org/packages/eightynine/filament-excel-import)
[![Total Downloads](https://img.shields.io/packagist/dt/eightynine/filament-excel-import.svg?style=flat-square)](https://packagist.org/packages/eightynine/filament-excel-import)

This package adds a new feature to your filament resource, allowing you to easily import data to your model

_This package brings the maatwebsite/laravel-excel functionalities to filament. You can use all the maatwebsite/laravel-excel features in your laravel project_

## Installation

You can install the package via composer:

```bash
composer require eightynine/filament-excel-import
```

## Usage

Before using this action, make sure to allow [Mass Assignment](https://laravel.com/docs/10.x/eloquent#mass-assignment) for your model. If you are doing a custom import, this is not necessary.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone', 'email'];
}
```

For example, if you have a 'ClientResource' in your project, integrate the action into ListClients class as demonstrated below:

```php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}

```

### Custom Import

If you wish to use your own import class to change the import procedure, you can use your own Import class.

```bash
php artisan make:import MyClientImport
```

Then in your action use your client imeport class
```php

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->slideOver()
                ->color("primary")
                ->use(App\Imports\MyClientImport::class),
            Actions\CreateAction::make(),
        ];
    }
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Eighty Nine](https://github.com/eighty9nine)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
