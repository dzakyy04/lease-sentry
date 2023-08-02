<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document2021 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'progress' => '{"masuk":{"day":0,"isCompleted":false},"dinilai":{"day":0,"isCompleted":false},"selesai":{"day":0,"isCompleted":false}}'
    ];

    public function user_pkn()
    {
        return $this->belongsTo(User::class, 'user_id_pkn');
    }

    public function user_penilai()
    {
        return $this->belongsTo(User::class, 'user_id_penilai');
    }
    
}
