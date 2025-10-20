<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar se o usuário já avaliou este vendedor para este veículo
        $existingRating = Rating::where('user_id', $request->user()->id)
            ->where('seller_id', $request->seller_id)
            ->where('vehicle_id', $request->vehicle_id)
            ->first();

        if ($existingRating) {
            return response()->json([
                'message' => 'Você já avaliou este vendedor para este veículo'
            ], 400);
        }

        $rating = Rating::create([
            'user_id' => $request->user()->id,
            'seller_id' => $request->seller_id,
            'vehicle_id' => $request->vehicle_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true // Em produção, poderia exigir moderação
        ]);

        // Atualizar rating do vendedor
        $this->updateSellerRating($request->seller_id);

        return response()->json($rating, 201);
    }

    public function getSellerRatings($sellerId)
    {
        $ratings = Rating::with('user')
            ->where('seller_id', $sellerId)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($ratings);
    }

    private function updateSellerRating($sellerId)
    {
        $seller = User::find($sellerId);
        $ratings = Rating::where('seller_id', $sellerId)
            ->where('is_approved', true)
            ->get();

        if ($ratings->count() > 0) {
            $averageRating = $ratings->avg('rating');
            $seller->update([
                'rating' => round($averageRating, 2),
                'rating_count' => $ratings->count()
            ]);
        }
    }
}