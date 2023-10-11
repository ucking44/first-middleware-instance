<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    protected $table = "notification_types";

    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function templates()
    {
        return $this->hasMany(Template::class);
    }
    public function groups()
    {
        return $this->belongsToMany(EmailGroup::class, 'email_group_notifications',
         'notification_type_id', 'email_group_id')->withPivot('created_at',"email_copy");
    }
}
