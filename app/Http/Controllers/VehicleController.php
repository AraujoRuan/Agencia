<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}