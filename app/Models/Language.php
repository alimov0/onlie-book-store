<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Language extends Model
{
    protected $fillable = ['name', 'prefix', 'is_active'];
}

