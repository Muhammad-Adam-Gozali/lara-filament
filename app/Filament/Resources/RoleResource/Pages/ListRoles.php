<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    public Collection $permissions;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data) {
                    $this->permissions = collect($data)
                        ->filter(fn ($permission, $key) => ! in_array($key, ['name', 'guard_name', 'select_all', Utils::getTenantModelForeignKey()]))
                        ->values()
                        ->flatten()
                        ->unique();

                    if (Arr::has($data, Utils::getTenantModelForeignKey())) {
                        return Arr::only($data, ['name', 'guard_name', Utils::getTenantModelForeignKey()]);
                    }

                    return Arr::only($data, ['name', 'guard_name']);
                })
                ->after(function ($record) {
                    $permissionModels = collect();

                    $this->permissions->each(function ($permission) use ($permissionModels, $record) {
                        $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                            'name'       => $permission,
                            'guard_name' => $record->guard_name,
                        ]));
                    });

                    $record->syncPermissions($permissionModels);
                }),
        ];
    }
    
}
