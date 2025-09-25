<?php

namespace App\Filament\Imports;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_code')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('middle_name')
                ->rules(['max:255']),
            ImportColumn::make('department_id')
            ->label('Department')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('country_id')
            ->label('Country')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('state_id')
            ->label('State')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('city_id')
            ->label('City')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('address')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('date_hired')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('date_of_birth')
                ->requiredMapping()
                ->rules(['required', 'date']),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        return Employee::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'employee_code' => $this->data['employee_code'],
        ]);

        // return new Employee();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

      protected function beforeValidate(): void
    {
        $department_id = Department::query()->where('name', $this->data['Department'])->first()?->id;
        $this->data['department_id'] = $department_id;
        $country_id = Country::query()->where('name', $this->data['Country'])->first()?->id;
        $this->data['country_id'] = $country_id;
        $state_id = State::query()->where('name', $this->data['State'])->first()?->id;
        $this->data['state_id'] = $state_id;
        $city_id = City::query()->where('name', $this->data['City'])->first()?->id;
        $this->data['city_id'] = $city_id;
    }
}
