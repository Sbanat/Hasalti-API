<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
        return Balance::where('user_id', $request->user()->id)->get();
    }

    public function updateOrCreate(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $balance = Balance::updateOrCreate(
            ['user_id' => $request->user()->id, 'currency' => $validated['currency']],
            ['amount' => $validated['amount']]
        );

        return response()->json($balance);
    }
}
