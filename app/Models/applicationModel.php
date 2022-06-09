<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicationModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
}
