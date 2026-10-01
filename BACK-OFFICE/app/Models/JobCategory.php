<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;





class JobCategory extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $table = 'job_categories';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    

}
