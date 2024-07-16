<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery_details extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'addr_line_1',
        'addr_line_2',
        'country',
        'company_email',
        'company_name',
        'company_reg_nr',
        'payment_method',
        'delivery_method',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id');
    }


}