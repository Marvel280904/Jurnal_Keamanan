<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    protected $fillable = ['journal_id', 'file_path', 'file_name'];

    public function journal() {
        return $this->belongsTo(Journal::class);
    }

    // Methods
    public function viewFile() {
        return [
            'name' => $this->file_name,
            'url'  => Storage::url($this->file_path)
        ];
    }

    public static function uploadFile($journalId, $file) {
        $path = $file->store('public/uploads/journals');
        
        return self::create([
            'journal_id' => $journalId,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteFile() {
        // Hapus file dari storage
        if (Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }
        // Hapus record dari database
        return $this->delete();
    }
}