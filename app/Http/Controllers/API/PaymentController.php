<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function plans()
    {
        $plans = Plan::where('is_active', true)->get();
        return response()->json($plans);
    }

    public function purchaseCredits(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|in:pix,credit_card,boleto'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $plan = Plan::find($request->plan_id);
        $user = $request->user();

        // Criar transação
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'credit_purchase',
            'amount' => $plan->price,
            'credits' => $plan->credits,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'metadata' => [
                'plan_name' => $plan->name,
                'plan_id' => $plan->id
            ]
        ]);

        // Integração com gateway de pagamento (exemplo simplificado)
        $paymentResult = $this->processPayment($transaction, $request->payment_method);

        if ($paymentResult['success']) {
            $transaction->update([
                'status' => 'completed',
                'payment_id' => $paymentResult['payment_id']
            ]);

            $user->addCredits($plan->credits);

            return response()->json([
                'message' => 'Créditos adquiridos com sucesso',
                'credits' => $user->credits,
                'transaction' => $transaction
            ]);
        } else {
            $transaction->update(['status' => 'failed']);

            return response()->json([
                'message' => 'Falha no processamento do pagamento'
            ], 400);
        }
    }

    public function featureVehicle(Request $request, $id)
    {
        $vehicle = Vehicle::where('user_id', $request->user()->id)->findOrFail($id);
        $user = $request->user();

        $cost = 50; // custo em créditos para destacar veículo

        if ($user->credits < $cost) {
            return response()->json([
                'message' => 'Créditos insuficientes'
            ], 400);
        }

        // Deduzir créditos
        if ($user->deductCredits($cost)) {
            $vehicle->update([
                'is_featured' => true,
                'featured_until' => now()->addDays(7)
            ]);

            // Registrar transação
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'featured_ad',
                'amount' => 0, // já pago com créditos
                'credits' => -$cost,
                'payment_method' => 'credits',
                'status' => 'completed',
                'metadata' => [
                    'vehicle_id' => $vehicle->id,
                    'vehicle_title' => $vehicle->title
                ]
            ]);

            return response()->json([
                'message' => 'Veículo destacado com sucesso',
                'credits' => $user->credits,
                'vehicle' => $vehicle
            ]);
        }

        return response()->json([
            'message' => 'Erro ao processar a solicitação'
        ], 500);
    }

    public function highlightVehicle(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required|in:red,blue,green,gold'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle = Vehicle::where('user_id', $request->user()->id)->findOrFail($id);
        $user = $request->user();

        $cost = 30; // custo em créditos para realçar veículo

        if ($user->credits < $cost) {
            return response()->json([
                'message' => 'Créditos insuficientes'
            ], 400);
        }

        // Deduzir créditos
        if ($user->deductCredits($cost)) {
            $vehicle->update([
                'is_highlighted' => true,
                'highlight_color' => $request->color
            ]);

            // Registrar transação
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'highlighted_ad',
                'amount' => 0,
                'credits' => -$cost,
                'payment_method' => 'credits',
                'status' => 'completed',
                'metadata' => [
                    'vehicle_id' => $vehicle->id,
                    'vehicle_title' => $vehicle->title,
                    'color' => $request->color
                ]
            ]);

            return response()->json([
                'message' => 'Veículo realçado com sucesso',
                'credits' => $user->credits,
                'vehicle' => $vehicle
            ]);
        }

        return response()->json([
            'message' => 'Erro ao processar a solicitação'
        ], 500);
    }

    public function transactionHistory(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($transactions);
    }

    private function processPayment($transaction, $method)
    {
        // Implementar integração com gateway de pagamento real
        // Esta é uma implementação de exemplo
        return [
            'success' => true,
            'payment_id' => 'pay_' . uniqid()
        ];
    }
}