<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('user')->active();

        // Aplicar filtros
        if ($request->hasAny(['brand', 'model', 'min_price', 'max_price', 'min_year', 'max_year', 'state', 'fuel_type', 'transmission'])) {
            $query->search($request->all());
        }

        // Ordenação
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $vehicles = $query->paginate(12);

        return response()->json($vehicles);
    }

    public function featured()
    {
        $vehicles = Vehicle::with('user')
            ->active()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json($vehicles);
    }

    public function show($id)
    {
        $vehicle = Vehicle::with('user')->active()->findOrFail($id);
        $vehicle->incrementViews();

        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|in:gasoline,ethanol,diesel,electric,hybrid',
            'transmission' => 'required|in:manual,automatic',
            'color' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:100',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = $request->user()->id;

        // Processar upload de imagens
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = $imagePaths;
        }

        $vehicle = Vehicle::create($data);

        return response()->json($vehicle, 201);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('user_id', $request->user()->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'brand' => 'sometimes|string|max:100',
            'model' => 'sometimes|string|max:100',
            'year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'sometimes|integer|min:0',
            'fuel_type' => 'sometimes|in:gasoline,ethanol,diesel,electric,hybrid',
            'transmission' => 'sometimes|in:manual,automatic',
            'color' => 'sometimes|string|max:50',
            'price' => 'sometimes|numeric|min:0',
            'state' => 'sometimes|string|max:2',
            'city' => 'sometimes|string|max:100',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Processar novas imagens
        if ($request->hasFile('images')) {
            // Remover imagens antigas
            if ($vehicle->images) {
                foreach ($vehicle->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = $imagePaths;
        }

        $vehicle->update($data);

        return response()->json($vehicle);
    }

    public function destroy(Request $request, $id)
    {
        $vehicle = Vehicle::where('user_id', $request->user()->id)->findOrFail($id);

        // Remover imagens
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $vehicle->delete();

        return response()->json(['message' => 'Anúncio removido com sucesso']);
    }

    public function myVehicles(Request $request)
    {
        $vehicles = Vehicle::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($vehicles);
    }
}