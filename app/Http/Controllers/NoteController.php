<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Note;

use App\Models\Account;

use Illuminate\Support\Facades\DB;


class NoteController extends Controller
{
    public function index(Request $request){
        $account_id = $request->account_id;
        $notes = Note::whereHas('noteDetails', function ($query) use ($account_id) {
            $query->where('account_id', $account_id);
        })->get();

        $account = Account::find($account_id);

        return view('notes.index',['notes' => $notes, 'account_id' => $account_id, 'account' => $account]);
        
    }

    public function store(Request $request){
        $account_id = $request->input('account_id');
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'account_id' => 'required|numeric',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Create a new note
            $note = new Note();
            $note->title = $request->title;
            $note->content = $request->content; 
            $note->status = 'active';
            $note->save();
    
            // Get the ID of the newly created note
            $notes_id = $note->notes_id;
    
            // Associate the note with the account in the notes_details table
            DB::table('notes_details')->insert([
                'notes_id' => $notes_id,
                'account_id' => $request->account_id,
            ]);
    
            // Commit the transaction if everything succeeds
            DB::commit();
    
            // Return success response
            return redirect()->back()->with('success', 'Note created successfully');
        } catch (\Exception $e) {
            dd($e);
            // If an error occurs, rollback the transaction
            DB::rollback();
    
            // Log the error or handle it accordingly
            return redirect()->back()->with('error', 'Error creating note');
        }
    }
    

    public function destroy($id) {
        try {
            // Find the note by ID
            $note = Note::findOrFail($id);
    
            // Delete the note
            $note->delete();
    
            // Redirect back to the page with a success message
            return redirect()->back()->with('success', 'Note deleted successfully');
        } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect()->back()->with('error', 'Error deleting note');
        }
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:active,finished', 
        ]);

        try {
            $note = Note::findOrFail($id);
            $note->title = $request->title;
            $note->content = $request->content;
            $note->status = $request->status;
            $note->save();

            return redirect()->back()->with('success', 'Note updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating note');
        }
    }

}
