<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $clients = Users::all();
        return view('users.index', compact('users'));
        // Отримати itemsPerPage з запиту або стандартне значення 10
        $itemsPerPage = $request->input('itemsPerPage', 10);

        $query = \App\Models\Client::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }


        $clients = $query->paginate($itemsPerPage)->appends($request->all());

        return view('clients.index', compact('clients', 'itemsPerPage'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            // додай інші поля за потребою
        ]);

        Users::create($request->all());

        return redirect()->route('users.index')->with('success', 'Клієнт створений!');
    }

    public function show(Users $client)
    {
        return view('users.show', compact('client'));
    }

    public function edit(Users $client)
    {
        return view('users.edit', compact('client'));
    }

    public function update(Request $request, Users $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
        ]);

        $client->update($request->all());

        return redirect()->route('users.index')->with('success', 'Клієнт оновлений!');
    }

    public function destroy(Users $client)
    {
        $client->delete();
        return redirect()->route('users.index')->with('success', 'Клієнт видалений!');
    }
}
