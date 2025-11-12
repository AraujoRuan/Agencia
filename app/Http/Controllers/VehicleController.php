<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Vehicle::with('user')->active();

        // Aplicar filtros
        if ($request->hasAny(['brand', 'model', 'min_price', 'max_price', 'min_year', 'max_year', 'state', 'fuel_type', 'transmission'])) {
            $filters = $request->all();
            $query->search($filters);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id): View
    {
        $vehicle = Vehicle::with('user')->active()->findOrFail($id);
        $vehicle->incrementViews();

        return view('vehicles.show', compact('vehicle'));
    }

    public function myVehicles(Request $request): View
    {
        $vehicles = Vehicle::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vehicles.my-vehicles', compact('vehicles'));
    }

    public function create(): View
    {
        return view('vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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

        $validated['user_id'] = $request->user()->id;

        // Processar upload de imagens
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        Vehicle::create($validated);

        return redirect()->route('my-vehicles')->with('success', 'Veículo anunciado com sucesso!');
    }

    public function edit($id): View
    {
        $vehicle = Vehicle::where('user_id', auth()->id())->findOrFail($id);
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $vehicle = Vehicle::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
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
            $validated['images'] = $imagePaths;
        }

        $vehicle->update($validated);

        return redirect()->route('my-vehicles')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy($id): RedirectResponse
    {
        $vehicle = Vehicle::where('user_id', auth()->id())->findOrFail($id);

        // Remover imagens
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $vehicle->delete();

        return redirect()->route('my-vehicles')->with('success', 'Veículo excluído com sucesso!');
    }
}