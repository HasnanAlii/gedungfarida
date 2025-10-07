<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Tampilkan daftar service
     */
    public function index()
    {
        $services = Service::paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Form tambah service baru
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Simpan service baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        Service::create([
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    /**
     * Form edit service
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update service
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    /**
     * Hapus service
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}
