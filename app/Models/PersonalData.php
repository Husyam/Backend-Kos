<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender' ,
        'profession' ,
        'contact' ,
        'id_user' ,
        'is_default' ,
    ];

    protected $primaryKey = 'id_personal_data';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
