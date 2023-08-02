<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document2020 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'progress' => '{"masuk":{"day":0,"isCompleted":false,"completion_date":null},"dinilai":{"day":0,"isCompleted":false,"completion_date":null},"selesai":{"day":0,"isCompleted":false,"completion_date":null}}'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
