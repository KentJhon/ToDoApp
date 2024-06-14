<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\StrongPassword;
use App\Rules\PhoneNumber;
use App\Rules\EmailAddress;
use App\Models\Note;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index() {
        return view('register.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }

    public function admin()
    {
        $accounts = Account::all();
        return view('admin.index', ['accounts' => $accounts]);
    }

    public function delete($id)
    {
        $account = Account::findOrFail($id);

        // Retrieve associated note_ids from notes_details table
        $noteIds = $account->notesDetails()->pluck('notes_id')->toArray();

        // Delete associated notes
        Note::whereIn('notes_id', $noteIds)->delete(); // Assuming 'id' is the primary key column name in the 'notes' table

        // Delete related records in notes_details table
        $account->notesDetails()->delete();

        // Delete the account
        $account->delete();

        return redirect()->route('admin.index')->with('success', 'Account and associated notes deleted successfully');
    }


    public function deleteAcc($id)
    {
        $account = Account::findOrFail($id);

        // Retrieve associated note_ids from notes_details table
        $noteIds = $account->notesDetails()->pluck('notes_id')->toArray();

        // Delete associated notes
        Note::whereIn('notes_id', $noteIds)->delete(); // Assuming 'id' is the primary key column name in the 'notes' table

        // Delete related records in notes_details table
        $account->notesDetails()->delete();

        // Delete the account
        $account->delete();

        return redirect()->route('login.index')->with('success', 'Account and associated notes deleted successfully');
    }


    public function getAssociatedNotes($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }

        // Retrieve associated note_ids from notes_details table
        $noteIds = $account->notesDetails()->pluck('note_id')->toArray();

        return response()->json(['note_ids' => $noteIds]);
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json(['unique' => !$exists]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:accounts,email',new EmailAddress],
            'phone' => ['required', 'string', 'min:11', new PhoneNumber],
            'password' => ['required', 'string', 'min:8', 'confirmed',new StrongPassword],
            ]);
    
            $newAccount = Account::create($data);
    
            return redirect(route('login.index'));
    }
    public function checkUsername(Request $request)
{
    $username = $request->input('username');
    $exists = User::where('username', $username)->exists();

    return response()->json(['exists' => $exists]);
}


    //settings -- Modified for validation
    public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*?&-_~`]/',  // must contain a special character
        ],
    ]);

    try {
        $account = Account::findOrFail($id);
        $account->username = $request->username;
        $account->password = ($request->password); 
        $account->save();

        return redirect()->back()->with('success', 'Account updated successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error updating account');
    }
}

}
