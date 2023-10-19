<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Enrollment extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "enrollments";

    protected $primaryKey = "id";

    protected $fillable = [
        'loyalty_program_id',
        'branch_id',
        'branch_code',
        'tier_id',
        'branch_codes',
        'cron_id',
        'loyalty_number',
        'account_number',
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
        'token',
        'receive_notification',
        'gender',
        'current_bal',
        'total_credit',
        'total_debit',
        'blocked_points',
        //'member_reference',
        'member_reference',
        'first_login',
        'first_login_time',
        'terms_agreed',
        'last_change_password',
        'password',
        'pin',
        'enrollment_status',
        'tries',
        'birthday',
        'anniversary',
        'status',
        'date_enrolled',
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
       'password',
        'pin'
    ];


    public function LoyaltyProgram(){
        return $this->belongsTo(LoyaltyProgram::class, 'loyalty_program_id');
    }

    public function EmailReportLog(){
        return $this->belongsTo(EmailReportLog::class);
    }


}
