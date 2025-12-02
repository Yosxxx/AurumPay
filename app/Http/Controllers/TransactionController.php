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
}
