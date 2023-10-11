<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailReportLog extends Model
{
    use HasFactory;

    protected $table = "email_report_logs";

    protected $guarded =['id'];
    
    //protected $primaryKey = "id";

    // protected $fillable = [
    //     'enrollment_id',
    //     'email',
    //     'status',
    //     'email_body',
    //     'subject'
    // ];

    public function Enrollment(){
        $this->hasOne(Enrollment::class);
    }
}
