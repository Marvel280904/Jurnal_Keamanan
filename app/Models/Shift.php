<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['nama_shift', 'mulai_shift', 'selesai_shift', 'status'];
}