<?php

namespace App\Models;

use App\Models\Conceptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document2020 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function conceptor()
    {
        return $this->belongsTo(Conceptor::class);
    }
}
