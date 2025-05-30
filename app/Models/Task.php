<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(User::class);
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
}
