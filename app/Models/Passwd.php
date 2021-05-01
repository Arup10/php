<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passwd extends Model
{
    protected $primaryKey = 'user';

    protected $keyType = 'string';

    public $timestamps = false;

    use HasFactory;
}
