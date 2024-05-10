<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $primaryKey = 'note_id';
    
    protected $fillable = [
        'title',
        'content'
    ];

    public function noteDetails()
    {
        return $this->hasMany(NoteDetails::class, 'note_id', 'note_id');
    }
}
