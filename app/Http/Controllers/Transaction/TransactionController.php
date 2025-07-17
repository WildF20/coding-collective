<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    protected $id;

    public function __construct(){
        $this->id = Auth::id() ?? 1;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $transaction = Transaction::where('user_id', $this->id)
                ->orderBy('created_at', 'desc')
                ->get();    
        } catch (\Exception $e) {
            \Log::error("message: " . $e->getMessage());
            $transaction = [];
        }
        
        return DataTables::of($transaction)->toJson(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->id;

        $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,failed,success',
        ]);

        try {
            $transaction = Transaction::create([
                'user_id' => $user,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);
        } catch (\Exception $e) {
            \Log::error("message: " . $e->getMessage());
            return response()->json(['error' => 'Transaction creation failed'], 500);
        }

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_id = $this->id;
        $trans_id = $id;

        try {
            $transaction = Transaction::where('id', $trans_id)
                ->where('user_id', $user_id)
                ->first();
        } catch (\Exception $e) {
            \Log::error("message: " . $e->getMessage());
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($transaction) {
            return response()->json($transaction, 200);
        } else {
            return response()->json(['error' => 'Transaction not found or not authorized'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = $this->id;
        $trans_id = $id;

        $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,failed,success',
        ]);

        try {
            $transaction = Transaction::where('id', $trans_id)
                ->where('user_id', $user_id)
                ->update([
                    'amount' => $request->amount,
                    'status' => $request->status,
                ]);
        } catch (\Exception $e) {
            \Log::error("message: " . $e->getMessage());
            return response()->json(['error' => 'Transaction update failed'], 500);
        }

        if ($transaction) {
            return response()->json(['message' => 'Transaction updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Transaction not found or not authorized'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_id = $this->id;
        $trans_id = $id;

        try {
            $transaction = Transaction::where('id', $trans_id)
                ->where('user_id', $user_id)
                ->delete();
        } catch (\Exception $e) {
            \Log::error("message: " . $e->getMessage());
            return response()->json(['error' => 'Transaction deletion failed'], 500);
        }

        if ($transaction) {
            return response()->json(['message' => 'Transaction deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Transaction not found or not authorized'], 404);
        }
    }
}
