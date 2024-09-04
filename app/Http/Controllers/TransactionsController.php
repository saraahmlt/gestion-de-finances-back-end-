<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
   
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:revenu,dépense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $userId = Auth::id();

        $transactionData = $request->only(['name', 'type', 'amount', 'date', 'description']);
        $transactionData['user_id'] = $userId;

        $transaction = Transaction::create($transactionData);
        return response()->json($transaction, 201);
    }

 
    public function show($id)
    {
        $transaction = Transaction::find($id);
    
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    
        return response()->json($transaction);
    }
    
    public function update(Request $request, $id)
    {

        $transaction = Transaction::find($id);
    

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
    
     
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:revenu,dépense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
    

        $transaction->update($validatedData);
    
    
        return response()->json(['transaction' => $transaction]);
    }
    
    
    


   
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
    
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $transaction->delete();
    
        return response()->json(null, 204);
    }
    
}
