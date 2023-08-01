<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document2021 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'progress' => '{"masuk":{"day":0,"isCompleted":false,"completion_date":null},"dinilai":{"day":0,"isCompleted":false,"completion_date":null},"selesai":{"day":0,"isCompleted":false,"completion_date":null}}'
    ];

    public function conceptor()
    {
        return $this->belongsTo(Conceptor::class);
    }
}
