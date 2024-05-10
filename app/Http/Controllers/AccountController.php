<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $noteIds = $account->notesDetails()->pluck('note_id')->toArray();

        // Delete associated notes
        Note::whereIn('note_id', $noteIds)->delete(); // Assuming 'id' is the primary key column name in the 'notes' table

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
        $noteIds = $account->notesDetails()->pluck('note_id')->toArray();

        // Delete associated notes
        Note::whereIn('note_id', $noteIds)->delete(); // Assuming 'id' is the primary key column name in the 'notes' table

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $newAccount = Account::create($data);

        return redirect(route('login.index'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $account = Account::findOrFail($id);
            $account->username = $request->username;
            $account->password = $request->password;
            $account->save();

            return redirect()->back()->with('success', 'Account updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating Account');
        }
    }
}
