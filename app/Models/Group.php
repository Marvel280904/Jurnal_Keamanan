<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['nama_grup'];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function journals() {
        return $this->hasMany(Journal::class);
    }

    // Methods
    public static function viewGroup() {
        return self::all();
    }

    public static function createGroup($data) {
        return self::create($data);
    }

    public function editGroup($data) {
        return $this->update($data);
    }

    public function deleteGroup() {
        return $this->delete();
    }
}