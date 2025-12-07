<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Overview Page (/dashboard)
    public function overview()
    {
        $recent = \App\Models\Transaction::where('user_id', auth()->id())
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard.overview', [
            'recent' => $recent,
        ]);
    }

    // Activity Page (/dashboard/activity)
    public function index(Request $request)
    {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
                        ->latest()
                        ->paginate(10);

        return view('dashboard.activity', [
            'transactions' => $transactions,
        ]);
    }

    public function handleFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type'   => 'required|in:deposit,withdraw'
        ]);

        $user = auth()->user();
        $amount = $request->amount;

        if ($request->type === 'withdraw' && $user->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.']);
        }

        DB::transaction(function () use ($user, $request, $amount) {
            if ($request->type === 'deposit') {
                $user->increment('balance', $amount);
            } else {
                $user->decrement('balance', $amount);
            }

            \App\Models\Transaction::create([
                'user_id'     => $user->id,
                'type'        => $request->type,
                'amount'      => $request->type === 'deposit' ? $amount : -$amount,
                'description' => ucfirst($request->type),
                'notes'       => 'Manual transaction via Dashboard',
            ]);
        });

        return back()->with('success', 'Transaction successful.');
    }
    public function transfer(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|exists:users,account_number',
            'amount'         => 'required|numeric|min:1',
            'notes'          => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $amount = $request->amount;
        $recipient = \App\Models\User::where('account_number', $request->account_number)->first();

        if (!$recipient) {
            return back()->withErrors(['account_number' => 'Recipient not found.']);
        }

        if ($user->id === $recipient->id) {
            return back()->withErrors(['account_number' => 'You cannot transfer money to yourself.']);
        }

        if ($user->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.']);
        }

        DB::transaction(function () use ($user, $recipient, $amount, $request) {
            // Deduct from sender
            $user->decrement('balance', $amount);
            
            // Add to recipient
            $recipient->increment('balance', $amount);

            // Create transaction record for sender
            \App\Models\Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'transfer',
                'amount'      => -$amount,
                'description' => 'Transfer to ' . $recipient->name,
                'notes'       => $request->notes,
            ]);

            // Create transaction record for recipient
            \App\Models\Transaction::create([
                'user_id'     => $recipient->id,
                'type'        => 'transfer',
                'amount'      => $amount,
                'description' => 'Transfer from ' . $user->name,
                'notes'       => $request->notes,
            ]);
        });

        return back()->with('success', 'Transfer successful!');
    }
}
