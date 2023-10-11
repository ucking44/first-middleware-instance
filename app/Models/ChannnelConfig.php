<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannnelConfig extends Model
{
    use HasFactory;

    protected $table = "channel_configs";

    protected $primaryKey = "id";

    protected $fillable = [
        'target',
        'config',
        'sender_id',
        'sender_name',
        'header',
        'status',
    ];

    public function channel()
    {
        return $this->belongsTo(ChannelProvider::class);
    }
}
