<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;


class company extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $table = 'companies';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'website',
        'industry',
        'ownerId',
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function jobVacancies(): hasMany
    {
        return $this->hasMany(JobVacncy::class, 'companyId','id');
    }

}
