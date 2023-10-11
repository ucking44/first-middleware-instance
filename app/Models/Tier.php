<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $table = "tiers";

    protected $primaryKey = "id";

    protected $fillable = [
        'tier_name',
        'status',
    ];

}
