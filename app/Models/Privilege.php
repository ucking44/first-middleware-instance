<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $table = "privileges";

    protected $primaryKey = "id";

    protected $fillable = [
        'ugp_id',
        'name',
        'slug',
        'status',
    ];

}
