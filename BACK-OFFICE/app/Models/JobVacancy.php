<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobVacancy extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $table = 'job_vacancies';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'categoryId',
        'companyId',
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'categoryId', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'jobVacancyId', 'id');
    }
}
