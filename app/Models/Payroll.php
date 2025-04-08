<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        "payroll_type_id",
        "reference_no",
        "employee_id",
        "account_id",
        "user_id",
        "salary",
        "amount",
        "paying_method",
        "note",
        "created_at"
    ];

    public function payrollType()
    {
        return $this->belongsTo('App\Models\PayrollType');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
