<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   public function canAccessPanel(Panel $panel): bool
{
    // Filter domain
    if (! str_ends_with($this->email, '@gmail.com')) {
        return false;
    }

    // Kalau belum verify, izinkan login tapi arahkan ke notice
    if (! $this->hasVerifiedEmail()) {
        return true; // biarkan Filament handle redirect ke verify page
    }

    return true;
}

protected static function booted(): void
{
    static::created(function (User $user) {
          if (app()->runningInConsole()) {
            return;
        }
        if (\Spatie\Permission\Models\Role::where('name', 'user')->exists()) {
            $user->assignRole('user');
        }
    });
}


}
