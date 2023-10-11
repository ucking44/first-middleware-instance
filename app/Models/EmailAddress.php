<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddress extends Model
{
    use HasFactory;

    protected $table = "email_addresses";

    protected $primaryKey = "id";

    protected $fillable = [
        'email',
        'status',
    ];

    public function groups()
    {
        return $this->belongsToMany(EmailGroup::class, 'email_group_addresses',
         'email_address_id', 'email_group_id')->withPivot('created_at');
    }
}
