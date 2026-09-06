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
        return $this->belongsTo(PayrollType::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
