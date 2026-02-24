<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['username', 'password', 'nama', 'role', 'group_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password'];

    // Relasi
    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function journals() {
        return $this->hasMany(Journal::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    public static function viewUser() {
        return self::all();
    }

    public static function createUser($data) {
        return self::create($data);
    }

    public function editUser($data) {
        return $this->update($data);
    }

    public function deleteUser() {
        return $this->delete();
    }
}
