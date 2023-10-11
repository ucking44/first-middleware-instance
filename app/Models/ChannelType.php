<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelType extends Model
{
    use HasFactory;

    protected $table = "channel_types";

    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'slug',
        'validate',
        'status',
        'created_at'
    ];

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
