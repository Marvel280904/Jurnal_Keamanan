<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['nama_shift', 'mulai_shift', 'selesai_shift', 'status'];

    // Methods
    public static function viewShift() {
        return self::all();
    }

    public static function addShift($data) {
        return self::create($data);
    }

    public function editShift($data) {
        return $this->update($data);
    }

    public function deleteShift() {
        return $this->delete();
    }

    public function updateStatus($status) {
        $this->status = $status;
        return $this->save();
    }
}