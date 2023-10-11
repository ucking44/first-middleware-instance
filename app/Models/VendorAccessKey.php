<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAccessKey extends Model
{
    use HasFactory;

    protected $table = "vendor_access_keys";

    protected $primaryKey = "id";

    protected $fillable = [
        "value",
    ];

}
