<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionChannel extends Model
{
    use HasFactory;

    protected $table = "transaction_channels";

    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'code',
        'company_id'
    ];

}
