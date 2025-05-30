<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;  // Import Str for uuid generation

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';     // The primary key type is string (UUID)
    public $incrementing = false;      // Not auto-incrementing

    protected $fillable = [
        'name',
        'email',
        'password',
        'supabase_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Auto-generate UUID when creating a new user
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
