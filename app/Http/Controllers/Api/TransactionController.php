<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Balance;

class TransactionController extends Controller
{
    public function recent(Request $request)
    {
        $userId = $request->user()->id;

        $incomes = Income::where('user_id', $userId)->latest()->take(5)->get();
        $expenses = Expense::where('user_id', $userId)->latest()->take(5)->get();

        $transactions = [];

        foreach ($incomes as $income) {
            $transactions[] = [
                'name' => $income->name,
                'amount' => $income->amount,
                'currency' => $income->currency,
                'type' => 'مدخول',
                'date' => $income->date,
            ];
        }

        foreach ($expenses as $expense) {
            $transactions[] = [
                'name' => $expense->name,
                'amount' => $expense->amount,
                'currency' => $expense->currency,
                'type' => 'مصروف',
                'date' => $expense->date,
            ];
        }

        usort($transactions, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
        $transactions = array_slice($transactions, 0, 5);

        $balances = Balance::where('user_id', $userId)->pluck('amount', 'currency');

        return response()->json([
            'transactions' => $transactions,
            'balances' => $balances
        ]);
    }

    public function all(Request $request)
    {
        $userId = $request->user()->id;

        $incomes = Income::where('user_id', $userId)->get();
        $expenses = Expense::where('user_id', $userId)->get();

        $transactions = [];

        foreach ($incomes as $income) {
            $transactions[] = [
                'name' => $income->name,
                'amount' => $income->amount,
                'currency' => $income->currency,
                'type' => 'مدخول',
                'date' => $income->date,
            ];
        }

        foreach ($expenses as $expense) {
            $transactions[] = [
                'name' => $expense->name,
                'amount' => $expense->amount,
                'currency' => $expense->currency,
                'type' => 'مصروف',
                'date' => $expense->date,
            ];
        }

        usort($transactions, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

        return response()->json($transactions);
    }
}
