<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Conceptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document2020 extends Model
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
