<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['nama_lokasi', 'alamat_lokasi', 'status'];

    // Methods
    public static function viewLocation() {
        return self::all();
    }

    public static function addLocation($data) {
        return self::create($data);
    }

    public function editLocation($data) {
        return $this->update($data);
    }

    public function deleteLocation() {
        return $this->delete();
    }

    public function updateStatus($status) {
        $this->status = $status;
        return $this->save();
    }
}