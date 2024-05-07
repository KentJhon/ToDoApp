<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;

use  App\Models\NoteDetails;


class AccountController extends Controller

{
    public function index() {
        return view('register.index');
    }

    public function admin(){
        $accounts = Account::all();
        return view('admin.index',['accounts' => $accounts]);
    }

    public function delete($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect()->back()->with('error', 'Account not found.');
        }

        // Check if there are any related notes associated with the account
        $relatedNotesExist = $account->notesDetails()->exists();

        // If related notes exist, delete them first
        if ($relatedNotesExist) {
            $account->notesDetails()->delete();
        }

        // Then delete the account
        $account->delete();

        return redirect()->back()->with('success', 'Account and associated notes deleted successfully.');
    }

    public function getAssociatedNotes($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }

        $notes = $account->notesDetails;

        return response()->json(['notes' => $notes]);
    }

    
    public function store(Request $request){
        $data = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);
        
        
        $newAccount = Account::create($data);

        return redirect(route('login.index'));
    }
}
