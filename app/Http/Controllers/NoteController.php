<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Note;

class NoteController extends Controller
{
    public function index(Request $request){
        $account_id = $request->account_id;
        $notes = Note::all();
        return view('notes.index',['notes' => $notes]);
        
    }

    public function store(Request $request){
        // Validate form data
        $account_id = $request->input('account_id');
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'account_id' => 'required|numeric',
        ]);

        // Create new note
        $note = new Note();
        $note->title = $request->title;
        $note->content = $request->content; 
        $note->account_id = $request->account_id;
        $note->save();

        // Return success response
        return response()->json(['message' => 'Note created successfully45458zz'], 200);
    }

}
