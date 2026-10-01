<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class resume extends Model
{
use SoftDeletes, HasFactory, HasUuids;

    protected $table = "resumes";

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'fileName',
        'fileUrl',
        'contactDetails',
        'skills',
        'experience',
        'summary',
        'userId',
    ];

    protected $dates = ['deleted_at'];

     protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'resumeId', 'id');
    }


}
