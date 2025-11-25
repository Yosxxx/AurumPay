<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    // -------------------------------------------------------------------------
    // Overview Page (/dashboard)
    // -------------------------------------------------------------------------
    public function overview()
    {
        $transactions = $this->dummyTransactions();

        // Last 5 recent
        $recent = array_slice(array_reverse($transactions), 0, 5);

        return view('dashboard.overview', [
            'recent' => $recent,
        ]);
    }

    // -------------------------------------------------------------------------
    // Activity Page (/dashboard/activity)
    // -------------------------------------------------------------------------
    public function index(Request $request)
    {
        $transactions = $this->dummyTransactions();

        // Pagination
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = array_slice($transactions, ($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $items,
            count($transactions),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard.activity', [
            'transactions' => $paginator,
        ]);
    }

    // -------------------------------------------------------------------------
    // Dummy Data (shared)
    // -------------------------------------------------------------------------
    private function dummyTransactions()
    {
        return [
            ['id' => 'TX-001', 'date' => 'Oct 01, 2023', 'desc' => 'Transfer Sent to John Doe', 'amount' => -150.0, 'type' => 'transfer', 'notes' => 'Monthly phone bill'],
            ['id' => 'TX-002', 'date' => 'Oct 02, 2023', 'desc' => 'Transfer Received from Sarah Lee', 'amount' => 850.0, 'type' => 'transfer', 'notes' => 'Payment for project collaboration'],
            ['id' => 'TX-003', 'date' => 'Oct 03, 2023', 'desc' => 'Transfer Sent to Kevin Hart', 'amount' => -42.0, 'type' => 'transfer', 'notes' => 'Shared dinner expenses'],
            ['id' => 'TX-004', 'date' => 'Oct 04, 2023', 'desc' => 'Transfer Received from Diana Miller', 'amount' => 1200.0, 'type' => 'transfer', 'notes' => 'Refund from friend'],
            ['id' => 'TX-005', 'date' => 'Oct 05, 2023', 'desc' => 'Transfer Sent to Alex Tan', 'amount' => -88.5, 'type' => 'transfer', 'notes' => 'Paid for class materials'],
            ['id' => 'TX-006', 'date' => 'Oct 06, 2023', 'desc' => 'Deposit', 'amount' => 430.0, 'type' => 'deposit', 'notes' => 'Cash deposit at ATM'],
            ['id' => 'TX-007', 'date' => 'Oct 07, 2023', 'desc' => 'Transfer Sent to Lisa Park', 'amount' => -215.0, 'type' => 'transfer', 'notes' => 'Rent split'],
            ['id' => 'TX-008', 'date' => 'Oct 08, 2023', 'desc' => 'Deposit Payroll', 'amount' => 900.0, 'type' => 'deposit', 'notes' => 'Salary for October'],
            ['id' => 'TX-009', 'date' => 'Oct 09, 2023', 'desc' => 'Transfer Sent to Maria Gomez', 'amount' => -60.75, 'type' => 'transfer', 'notes' => 'Shared subscription'],
            ['id' => 'TX-010', 'date' => 'Oct 10, 2023', 'desc' => 'Transfer Received from Daniel Lee', 'amount' => 310.0, 'type' => 'transfer', 'notes' => 'Meal reimbursement'],
            ['id' => 'TX-011', 'date' => 'Oct 11, 2023', 'desc' => 'Withdraw', 'amount' => -140.0, 'type' => 'withdraw', 'notes' => 'Cash withdrawal'],
            ['id' => 'TX-012', 'date' => 'Oct 12, 2023', 'desc' => 'Transfer Received from Amanda Diaz', 'amount' => 750.0, 'type' => 'transfer', 'notes' => 'Group trip settlement'],
            ['id' => 'TX-013', 'date' => 'Oct 13, 2023', 'desc' => 'Transfer Sent to David Brown', 'amount' => -98.0, 'type' => 'transfer', 'notes' => 'Shared utilities'],
            ['id' => 'TX-014', 'date' => 'Oct 14, 2023', 'desc' => 'Deposit', 'amount' => 1299.0, 'type' => 'deposit', 'notes' => 'Monthly bonus'],
            ['id' => 'TX-015', 'date' => 'Oct 15, 2023', 'desc' => 'Transfer Sent to Olivia Chen', 'amount' => -75.2, 'type' => 'transfer', 'notes' => 'Birthday gift contribution'],
            ['id' => 'TX-016', 'date' => 'Oct 16, 2023', 'desc' => 'Transfer Received from Ethan Lee', 'amount' => 540.0, 'type' => 'transfer', 'notes' => 'Shared PC part purchase'],
            ['id' => 'TX-017', 'date' => 'Oct 17, 2023', 'desc' => 'Withdraw', 'amount' => -33.0, 'type' => 'withdraw', 'notes' => 'Quick cash'],
            ['id' => 'TX-018', 'date' => 'Oct 18, 2023', 'desc' => 'Transfer Received from Jessica White', 'amount' => 265.0, 'type' => 'transfer', 'notes' => 'Team lunch reimbursement'],
            ['id' => 'TX-019', 'date' => 'Oct 19, 2023', 'desc' => 'Transfer Sent to Tyler Scott', 'amount' => -145.9, 'type' => 'transfer', 'notes' => 'Weekend outing'],
            ['id' => 'TX-020', 'date' => 'Oct 20, 2023', 'desc' => 'Deposit Payroll', 'amount' => 1100.0, 'type' => 'deposit', 'notes' => 'Main salary'],
            ['id' => 'TX-021', 'date' => 'Oct 21, 2023', 'desc' => 'Transfer Sent to Samuel Young', 'amount' => -58.4, 'type' => 'transfer', 'notes' => 'Dinner'],
            ['id' => 'TX-022', 'date' => 'Oct 22, 2023', 'desc' => 'Transfer Received from Brandon Cruz', 'amount' => 999.0, 'type' => 'transfer', 'notes' => 'Freelance payment'],
            ['id' => 'TX-023', 'date' => 'Oct 23, 2023', 'desc' => 'Withdraw', 'amount' => -120.0, 'type' => 'withdraw', 'notes' => 'ATM cash'],
            ['id' => 'TX-024', 'date' => 'Oct 24, 2023', 'desc' => 'Transfer Received from Nathan Price', 'amount' => 820.0, 'type' => 'transfer', 'notes' => 'Shared electronics purchase'],
            ['id' => 'TX-025', 'date' => 'Oct 25, 2023', 'desc' => 'Transfer Sent to Justin Lee', 'amount' => -46.0, 'type' => 'transfer', 'notes' => 'Snacks & drinks'],
            ['id' => 'TX-026', 'date' => 'Oct 26, 2023', 'desc' => 'Deposit', 'amount' => 200.0, 'type' => 'deposit', 'notes' => 'Cash top-up'],
            ['id' => 'TX-027', 'date' => 'Oct 27, 2023', 'desc' => 'Transfer Sent to Fiona Park', 'amount' => -89.99, 'type' => 'transfer', 'notes' => 'Class event payment'],
            ['id' => 'TX-028', 'date' => 'Oct 28, 2023', 'desc' => 'Transfer Received from Jason Yu', 'amount' => 777.77, 'type' => 'transfer', 'notes' => 'Split concert tickets'],
            ['id' => 'TX-029', 'date' => 'Oct 29, 2023', 'desc' => 'Withdraw', 'amount' => -64.5, 'type' => 'withdraw', 'notes' => 'Physical branch withdrawal'],
            ['id' => 'TX-030', 'date' => 'Oct 30, 2023', 'desc' => 'Transfer Received from Alice Tan', 'amount' => 355.0, 'type' => 'transfer', 'notes' => 'Shared groceries'],
            ['id' => 'TX-031', 'date' => 'Oct 31, 2023', 'desc' => 'Deposit', 'amount' => 1000.0, 'type' => 'deposit', 'notes' => 'Online funding from bank app'],
            ['id' => 'TX-032', 'date' => 'Nov 01, 2023', 'desc' => 'Withdraw', 'amount' => -220.0, 'type' => 'withdraw', 'notes' => 'Cash for daily needs'],
            ['id' => 'TX-033', 'date' => 'Nov 02, 2023', 'desc' => 'Transfer Sent to Brian Ho', 'amount' => -75.0, 'type' => 'transfer', 'notes' => 'Shared internet bill'],
            ['id' => 'TX-034', 'date' => 'Nov 03, 2023', 'desc' => 'Transfer Received from Joanne Kim', 'amount' => 420.0, 'type' => 'transfer', 'notes' => 'Paid for monthly rent difference'],
            ['id' => 'TX-035', 'date' => 'Nov 04, 2023', 'desc' => 'Withdraw', 'amount' => -95.0, 'type' => 'withdraw', 'notes' => 'Emergency cash'],
            ['id' => 'TX-036', 'date' => 'Nov 05, 2023', 'desc' => 'Deposit', 'amount' => 1180.0, 'type' => 'deposit', 'notes' => 'Monthly income'],
            ['id' => 'TX-037', 'date' => 'Nov 06, 2023', 'desc' => 'Transfer Sent to Aaron Lim', 'amount' => -140.0, 'type' => 'transfer', 'notes' => 'Work lunch split'],
            ['id' => 'TX-038', 'date' => 'Nov 07, 2023', 'desc' => 'Transfer Received from Charles Park', 'amount' => 360.0, 'type' => 'transfer', 'notes' => 'Overpaid balance return'],
            ['id' => 'TX-039', 'date' => 'Nov 08, 2023', 'desc' => 'Deposit', 'amount' => 500.0, 'type' => 'deposit', 'notes' => 'Cash deposit from savings'],
            ['id' => 'TX-040', 'date' => 'Nov 09, 2023', 'desc' => 'Transfer Sent to Cindy Lao', 'amount' => -35.0, 'type' => 'transfer', 'notes' => 'Grab ride share'],
            ['id' => 'TX-041', 'date' => 'Nov 10, 2023', 'desc' => 'Transfer Received from Henry Tan', 'amount' => 290.0, 'type' => 'transfer', 'notes' => 'Group fee split'],
            ['id' => 'TX-042', 'date' => 'Nov 11, 2023', 'desc' => 'Withdraw', 'amount' => -125.0, 'type' => 'withdraw', 'notes' => 'Night out cash'],
            ['id' => 'TX-043', 'date' => 'Nov 12, 2023', 'desc' => 'Transfer Sent to Cindy Wu', 'amount' => -56.0, 'type' => 'transfer', 'notes' => 'Movie tickets'],
            ['id' => 'TX-044', 'date' => 'Nov 13, 2023', 'desc' => 'Deposit', 'amount' => 800.0, 'type' => 'deposit', 'notes' => 'Freelance payout'],
            ['id' => 'TX-045', 'date' => 'Nov 14, 2023', 'desc' => 'Transfer Received from Victor Ong', 'amount' => 455.0, 'type' => 'transfer', 'notes' => 'Shared equipment'],
            ['id' => 'TX-046', 'date' => 'Nov 15, 2023', 'desc' => 'Withdraw', 'amount' => -90.0, 'type' => 'withdraw', 'notes' => 'Groceries cash'],
            ['id' => 'TX-047', 'date' => 'Nov 16, 2023', 'desc' => 'Transfer Sent to Rachel Chan', 'amount' => -77.0, 'type' => 'transfer', 'notes' => 'Coffee meet-up'],
            ['id' => 'TX-048', 'date' => 'Nov 17, 2023', 'desc' => 'Deposit', 'amount' => 650.0, 'type' => 'deposit', 'notes' => 'Business loan transfer'],
            ['id' => 'TX-049', 'date' => 'Nov 18, 2023', 'desc' => 'Transfer Received from Kelvin Tai', 'amount' => 380.0, 'type' => 'transfer', 'notes' => 'Shared travel booking'],
            ['id' => 'TX-050', 'date' => 'Nov 19, 2023', 'desc' => 'Withdraw', 'amount' => -120.0, 'type' => 'withdraw', 'notes' => 'Weekend expenses'],
        ];
    }
}
