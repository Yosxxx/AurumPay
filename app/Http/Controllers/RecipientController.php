<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipientController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Recipient::where('user_id', $userId);

        if($request->has('search') && $request->search !=''){
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('recipient_name', 'like', "%{$search}%")
                ->orWhere('recipient_account_number', 'like', "%{$search}%");
            });
        }

        $recipients = $query->latest()->paginate(10);

        return view('dashboard.recipients', compact('recipients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|exists:users,account_number',
            'name' => 'required|string|max:255'
        ]);

        if($request->account_number == Auth::user()->account_number){
            return back()->witherrors(['account_number' => 'You cannot add yourself as a recipient.']);
        }

        $exists = Recipient::where('user_id', Auth::id())
            ->where('recipient_account_number', $request->account_number)
            ->exists();

        if($exists){
            return back()->withErrors(['account_number' => 'This recipient is already in your list.']);
        }

        Recipient::create([
            'user_id' => Auth::id(),
            'recipient_account_number' => $request->account_number,
            'recipient_name' => $request->name,
        ]);

        

        return redirect()->back()->with('success', 'Recipient added successfully!');
    }

    public function verify(Request $request){
        $user = User::where('account_number', $request->account_number)->first();

        if(!$user){
            return response()->json(['status' => 'error', 'message' => 'Account not found.']);
        }

        if($user->id == Auth::id()){
            return response()->json(['status' => 'error', 'message' => 'You cannot add yourself!']);
        }

        $exists = Recipient::where('user_id', Auth::id())
            ->where('recipient_account_number', $request->account_number)
            ->exists();

        if($exists){
            return response()->json(['status' => 'error', 'message' => 'This Recipient is already in your list.']);
        }

        return response()->json(['status' => 'success', 'name' => $user->name]);
    }

}
