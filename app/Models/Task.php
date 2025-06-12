<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

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
        'status'
    ];


    // Cast attributes to proper types
    protected $casts = [
        'task_deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // Removed 'category' => 'array' because we're handling it with accessor/mutator
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
     * Handle category field - convert string to array if needed
     */
    protected function category(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (is_null($value)) {
                    return [];
                }

                // If it's already an array, return it
                if (is_array($value)) {
                    return $value;
                }

                // If it's a JSON string, decode it
                if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $decoded;
                    }
                }

                // If it's a comma-separated string, convert to array
                if (is_string($value)) {
                    return array_map('trim', explode(',', $value));
                }

                return [];
            },
            set: function ($value) {
                if (is_null($value)) {
                    return null;
                }

                if (is_array($value)) {
                    return json_encode($value);
                }

                if (is_string($value)) {
                    // Convert comma-separated string to array, then to JSON
                    $array = array_map('trim', explode(',', $value));
                    return json_encode($array);
                }

                return json_encode([]);
            }
        );
    }

    /**
     * Get the task's deadline in the correct timezone for display.
     */
    protected function taskDeadline(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->timezone('Asia/Manila') : null,
            set: fn ($value) => $value ? Carbon::parse($value)->utc() : null,
        );
    }

    /**
     * Handle created_at timezone conversion
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->timezone('Asia/Manila'),
        );
    }

    /**
     * Handle updated_at timezone conversion
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->timezone('Asia/Manila') : null,
        );
    }

    /**
     * Get the category attribute.
     */
    public function getCategoryAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($value) ? $value : [];
    }

    /**
     * Set the category attribute.
     */
    public function setCategoryAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['category'] = json_encode([$value]);
        } else {
            $this->attributes['category'] = json_encode(is_array($value) ? $value : []);
        }
    }
}
