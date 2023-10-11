<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = "routes";

    protected $primaryKey = "id";

    protected $fillable = [
        'priviledge_id',
        'route_name',
        'activity',
        'status',
    ];

}
