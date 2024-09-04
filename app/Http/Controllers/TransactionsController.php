<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Transaction ",
 *     version="1.0.0",
 *     description="API for managing transactions"
 * )
 */

class TransactionsController extends Controller
{
     /**
     * @OA\Get(
     *     path="/v1/transactions",
     *     summary="Get a list of transactions",
     *     tags={"Transactions"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of transactions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Transaction")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $userId = Auth::id();
        $transactions = Transaction::where('user_id', $userId)->get();
        return response()->json($transactions);
    }

      /**
     * @OA\Post(
     *     path="/v1/transactions",
     *     summary="Create a new transaction",
     *     tags={"Transactions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */

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

        /**
     * @OA\Get(
     *     path="/v1/transactions/{id}",
     *     summary="Get a specific transaction by ID",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the specified transaction",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     )
     * )
     */

 
     public function show($id)
     {
         $userId = Auth::id();
         $transaction = Transaction::where('id', $id)->where('user_id', $userId)->first();
     
         if (!$transaction) {
             return response()->json(['message' => 'Transaction not found'], 404);
         }
     
         return response()->json($transaction);
     }
 
    
        /**
     * @OA\Put(
     *     path="/v1/transactions/{id}",
     *     summary="Update an existing transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized to update this transaction"
     *     )
     * )
     */

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
    
    
    
       /**
     * @OA\Delete(
     *     path="/v1/transactions/{id}",
     *     summary="Delete a specific transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Transaction deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized to delete this transaction"
     *     )
     * )
     */

   
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
