<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- Import this
use Carbon\Carbon; // <-- Import Carbon

class Task extends Model
{
    protected $keyType = 'string';  // UUID primary key is string
    public $incrementing = false;   // Disable auto-incrementing

    protected $fillable = [
        'user_id',
        'task_name',
        'priority',
        'task_deadline',
        'task_description',
        'category',
        'image_url',
    ];

    /**
     * The user who owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'supabase_id');
    }

    /**
     * Boot function to auto-generate UUID on create.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

     /**
     * Get the task's deadline in the correct timezone for display.
     */
    protected function taskDeadline(): Attribute
    {
        return Attribute::make(
            // The 'get' accessor is called when you access the attribute
            get: fn ($value) => Carbon::parse($value)->timezone('Asia/Manila'),
        );
    }

    /**
     * You can do the same for created_at and updated_at
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->timezone('Asia/Manila'),
        );
    }
}
