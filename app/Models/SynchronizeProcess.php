<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SynchronizeProcess extends Model
{
    use HasFactory;

    protected $table = 'synchronize_process';

    protected $guarded = ['id'];
}
