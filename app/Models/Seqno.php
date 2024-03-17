<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seqno extends Model
{
    use HasFactory;

    protected $table = 'seqno';

    protected $guarded = ['id'];
}
