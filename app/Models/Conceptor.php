<?php

namespace App\Models;

use App\Models\Document2020;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conceptor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function document2020s()
    {
        return $this->hasMany(Document2020::class);
    }
}
