<?php

namespace EightyNine\ExcelImport;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DefaultImport implements ToCollection, WithHeadingRow
{
    public function __construct(
        public string $model,
        public array $attributes = []
    ) {
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->model::create($row->toArray());
        }
    }
}
