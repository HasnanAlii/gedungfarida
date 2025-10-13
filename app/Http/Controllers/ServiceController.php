<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        try {
            Service::create([
                'name'  => $request->name,
                'price' => $request->price,
            ]);

            return redirect()->route('services.index')
                ->withInput()
                ->with([
                    'message' => 'Layanan berhasil ditambahkan' ,
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Gagal menambahkan service: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
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

        try {
            $service = Service::findOrFail($id);
            $service->update([
                'name'  => $request->name,
                'price' => $request->price,
            ]);

            return redirect()->route('services.index')
                ->withInput()
                ->with([
                    'message' => 'Layanan berhasil diperbarui' ,
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Gagal memperbarui service: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Hapus service
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return redirect()->route('services.index')
                ->with([
                    'message' => 'Layanan berhasil dihapus  ' ,
                    'alert-type' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with([
                    'message' => 'Gagal menghapus Layanan : ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }
}
