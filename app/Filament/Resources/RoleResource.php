<?php
namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Forms\ShieldSelectAllToggle;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;


class RoleResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->unique(
                                        ignoreRecord: true, /** @phpstan-ignore-next-line */
                                        modifyRuleUsing: fn (Unique $rule) => Utils::isTenancyEnabled() ? $rule->where(Utils::getTenantModelForeignKey(), Filament::getTenant()?->id) : $rule
                                    )
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(Utils::getFilamentAuthGuard())
                                    ->nullable()
                                    ->maxLength(255),

                                Forms\Components\Select::make(config('permission.column_names.team_foreign_key'))
                                    ->label(__('filament-shield::filament-shield.field.team'))
                                    ->placeholder(__('filament-shield::filament-shield.field.team.placeholder'))
                                    /** @phpstan-ignore-next-line */
                                    ->default([Filament::getTenant()?->id])
                                    ->options(fn (): Arrayable => Utils::getTenantModel() ? Utils::getTenantModel()::pluck('name', 'id') : collect())
                                    ->hidden(fn (): bool => ! (static::shield()->isCentralApp() && Utils::isTenancyEnabled()))
                                    ->dehydrated(fn (): bool => ! (static::shield()->isCentralApp() && Utils::isTenancyEnabled())),
                                ShieldSelectAllToggle::make('select_all')
                                    ->onIcon('heroicon-s-shield-check')
                                    ->offIcon('heroicon-s-shield-exclamation')
                                    ->label(__('filament-shield::filament-shield.field.select_all.name'))
                                    ->helperText(fn (): HtmlString => new HtmlString(__('filament-shield::filament-shield.field.select_all.message')))
                                    ->dehydrated(fn (bool $state): bool => $state),

                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ]),
                    ]),
                static::getShieldFormComponents(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight('font-medium')
                    ->label(__('filament-shield::filament-shield.column.name'))
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('guard_name')
                    ->badge()
                    ->color('warning')
                    ->label(__('filament-shield::filament-shield.column.guard_name')),
                Tables\Columns\TextColumn::make('team.name')
                    ->default('Global')
                    ->badge()
                    ->color(fn (mixed $state): string => str($state)->contains('Global') ? 'gray' : 'primary')
                    ->label(__('filament-shield::filament-shield.column.team'))
                    ->searchable()
                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->badge()
                    ->label(__('filament-shield::filament-shield.column.permissions'))
                    ->counts('permissions')
                    ->colors(['success']),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-shield::filament-shield.column.updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (Model $record, array $data): array {
                        // Mengambil permissions yang sudah ada dan memasukkannya ke form
                        $data['permissions'] = $record->permissions()->pluck('name')->toArray();
                        return $data;
                    })
                    ->using(function (Model $record, array $data): Model {
                        // 1. Ekstrak permissions dari data form yang disubmit
                        $permissions = collect($data)
                            ->filter(fn ($permission, $key) => !in_array($key, ['name', 'guard_name', 'select_all', Utils::getTenantModelForeignKey()]))
                            ->values()
                            ->flatten()
                            ->unique();

                        // 2. Siapkan data untuk diupdate pada model Role
                        if (Arr ::has($data, Utils::getTenantModelForeignKey())) {
                            $roleData = Arr::only($data, ['name', 'guard_name', Utils::getTenantModelForeignKey()]);
                        } else {
                            $roleData = Arr::only($data, ['name', 'guard_name']);
                        }

                        // 3. Update data role (misal: nama role)
                        $record->update($roleData);

                        // 4. Proses dan sinkronisasi permissions
                        $permissionModels = collect();
                        $permissions->each(function ($permission) use ($permissionModels, $record) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name'       => $permission,
                                'guard_name' => $record->guard_name,
                            ]));
                        });

                        $record->syncPermissions($permissionModels);

                        return $record;
                    }),
                Tables\Actions\DeleteAction::make(),         
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            //    'create' => Pages\CreateRole::route('/create'),
            // 'view' => Pages\ViewRole::route('/{record}'),
            // 'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster() ?? static::$cluster;
    }

    public static function getModel(): string
    {
        return Utils::getRoleModel();
    }

    public static function getModelLabel(): string
    {
        return __('filament-shield::filament-shield.resource.label.role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-shield::filament-shield.resource.label.roles');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Utils::isResourceNavigationRegistered();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Access Roles';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return Utils::getSubNavigationPosition() ?? static::$subNavigationPosition;
    }

    public static function getSlug(): string
    {
        return Utils::getResourceSlug();
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
            ? strval(static::getEloquentQuery()->count())
            : null;
    }

    public static function isScopedToTenant(): bool
    {
        return Utils::isScopedToTenant();
    }

    public static function canGloballySearch(): bool
    {
        return Utils::isResourceGloballySearchable() && count(static::getGloballySearchableAttributes()) && static::canViewAny();
    }
}
