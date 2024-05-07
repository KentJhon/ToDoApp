<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteDetails extends Model
{
    use HasFactory;

    protected $table = 'notes_details';

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
