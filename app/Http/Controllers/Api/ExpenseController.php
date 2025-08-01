<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Balance;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        return Expense::where('user_id', $request->user()->id)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense = Expense::create([
            'user_id' => $request->user()->id,
            ...$validated,
        ]);

        Balance::updateOrCreate(
            ['user_id' => $request->user()->id, 'currency' => $validated['currency']],
            ['amount' => \DB::raw("amount - {$validated['amount']}")]
        );

        return response()->json($expense);
    }
}
