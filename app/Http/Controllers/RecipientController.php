<?php

namespace App\Http\Controllers;

class RecipientController extends Controller
{
    public function index()
    {
        $dummy = collect([
            ['name' => 'Ethan Clarke', 'number' => '321-889-112'],
            ['name' => 'Maya Thompson', 'number' => '554-210-998'],
            ['name' => 'Lucas Bennett', 'number' => '778-442-310'],
            ['name' => 'Ariana Hughes', 'number' => '992-631-407'],
            ['name' => 'Dylan Carter', 'number' => '110-743-558'],
            ['name' => 'Olivia Brooks', 'number' => '643-220-918'],
            ['name' => 'Noah Ramirez', 'number' => '984-551-733'],
            ['name' => 'Chloe Adams', 'number' => '227-119-674'],
            ['name' => 'Isaac Morgan', 'number' => '875-330-441'],
            ['name' => 'Sophia Turner', 'number' => '441-982-300'],
            ['name' => 'Nathan Price', 'number' => '219-450-780'],
            ['name' => 'Emma Foster', 'number' => '552-118-907'],
            ['name' => 'Caleb Knight', 'number' => '803-771-299'],
            ['name' => 'Bella Crawford', 'number' => '119-664-882'],
            ['name' => 'Henry Sullivan', 'number' => '330-907-655'],
        ]);

        // Paginate 12 per page
        $recipients = new \Illuminate\Pagination\LengthAwarePaginator(
            $dummy->forPage(request('page', 1), 12),
            $dummy->count(),
            12,
            request('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard.recipients', compact('recipients'));
    }
}
