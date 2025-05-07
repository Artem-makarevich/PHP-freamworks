<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Part;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index(Request $request)
    {
        $parts = Details::all();
        return view('parts.index', compact('parts'));
        $itemsPerPage = $request->input('itemsPerPage', 10);

        $query = \App\Models\Car::query();

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }
        if ($request->filled('license_plate')) {
            $query->where('license_plate', 'like', '%' . $request->license_plate . '%');
        }

        $cars = $query->paginate($itemsPerPage)->appends($request->all());

        return view('cars.index', compact('cars', 'itemsPerPage'));
    }

    public function create()
    {
        return view('details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        Detail::create($request->all());

        return redirect()->route('details.index')->with('success', 'Запчастина додана!');
    }

    public function show(Detail $part)
    {
        return view('details.show', compact('part'));
    }

    public function edit(Detail $part)
    {
        return view('details.edit', compact('part'));
    }

    public function update(Request $request, Part $part)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $part->update($request->all());

        return redirect()->route('details.index')->with('success', 'Запчастина оновлена!');
    }

    public function destroy(Detail $part)
    {
        $part->delete();
        return redirect()->route('details.index')->with('success', 'Запчастина видалена!');
    }
}
