<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdmisionController extends Controller
{
    public function index(Request $request)
    {
        $query = Matricula::query();

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('programa', 'like', "%{$search}%");
            });
        }

        $admisiones = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.admisiones.index', compact('admisiones'));
    }

    public function show($id)
    {
        $matricula = Matricula::findOrFail($id);
        return view('admin.admisiones.show', compact('matricula'));
    }

    public function update(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:pendiente,contactado,matriculado,cancelado',
            'notas' => 'nullable|string',
        ]);

        $matricula->update($request->only(['estado', 'notas']));

        return back()->with('success', 'Estado de la solicitud actualizado.');
    }

    public function destroy($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->delete();

        return redirect()->route('admin.admisiones.index')->with('success', 'Solicitud eliminada.');
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'admisiones_' . date('Y-m-d_His') . '.csv';
        $admisiones = Matricula::orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Nombre', 'Programa', 'Email', 'WhatsApp', 'Nacionalidad', 'Fecha Solicitud', 'Estado', 'Notas'];

        $callback = function () use ($admisiones, $columns) {
            $file = fopen('php://output', 'w');
            // Añadir BOM para que Excel abra UTF-8 correctamente
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($admisiones as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->nombre,
                    $item->programa,
                    $item->email,
                    $item->whatsapp,
                    $item->nacionalidad,
                    $item->created_at->format('Y-m-d H:i'),
                    $item->estado,
                    $item->notas,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
