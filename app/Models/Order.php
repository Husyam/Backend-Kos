<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_personal_data',
        'shipping_cost',
        'payment_va_name',
        'payment_va_number',
        'payment_ewallet',
        'sub_total',
        'total_cost',
        'status',
        'payment_method',
        'transaction_number',
    ];

    protected $primaryKey = 'id_order';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function personalData()
    {
        return $this->belongsTo(PersonalData::class, 'id_personal_data');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }




}
