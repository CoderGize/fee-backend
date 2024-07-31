<?php

namespace App\Http\Controllers\Api\DebtCard;

use App\Http\Controllers\Controller;
use App\Models\DebtCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtCardController extends Controller
{


    public function store(Request $request)
    {

        try {
        $request->validate([

            'account_name' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'security_code' => 'required|string|max:255',
        ]);


            $userId = Auth::id();
            $debtCard = new DebtCard();
            $debtCard->user_id = $userId;
            $debtCard->account_name = $request->account_name;
            $debtCard->bank = $request->bank;
            $debtCard->account_number = $request->account_number;
            $debtCard->expiry_date = $request->expiry_date;
            $debtCard->save();


        return response()->json([
            'status' => 'success',
           'message' => 'Debt card added successfully',
                'data'=>$debtCard
        ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add debt card', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_name' => 'string|max:255',
            'bank' => 'string|max:255',
            'account_number' => 'string|max:255',
            'expiry_date' => 'date',
            'security_code' => 'string|max:255',
        ]);

        try {

            $userId = Auth::id();
            $debtCard = DebtCard::where('user_id', $userId)->findOrFail($id);
            $debtCard->account_name = $request->account_name ?? $debtCard->account_name;
            $debtCard->bank = $request->bank ?? $debtCard->bank;
            $debtCard->account_number = $request->account_number ?? $debtCard->account_number;
            $debtCard->expiry_date = $request->expiry_date ?? $debtCard->expiry_date;

            $debtCard->save();

            return response()->json([
                'message' => 'Debt card updated successfully',
                'data'=>$debtCard
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update debt card', 'message' => $e->getMessage()], 500);
        }
    }
    public function index()
    {
        try {
            $userId = Auth::id();
            $debtCards = DebtCard::where('user_id', $userId)->get();
            return response()->json([
                'message'=>'successfully fetched',
                'data'=>$debtCards
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch debt cards', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::id();
            $debtCard = DebtCard::where('user_id', $userId)->findOrFail($id);
            $debtCard->delete();

            return response()->json(['message' => 'Debt card deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete debt card', 'message' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        try {
            $userId = Auth::id();
            $debtCard = DebtCard::where('user_id', $userId)->findOrFail($id);
            return response()->json($debtCard, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Debt card not found', 'message' => $e->getMessage()], 404);
        }
    }
}
