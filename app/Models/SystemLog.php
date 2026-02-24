<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'deskripsi'];

    // Relasi
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Methods
    public static function viewLog() {
        return self::with('user')->orderBy('created_at', 'desc')->get();
    }

    public static function recordLog($data) {
        return self::create($data);
    }
}