<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'url', 'headers'];

    public function getUrlAttribute($value)
    {
        return $value ?? env('WEBHOOK_URL');
    }
}
