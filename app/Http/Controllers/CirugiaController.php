<?php

namespace App\Http\Controllers;

use App\Models\Cirugia;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CirugiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hoy = Carbon::today();
        $noti = Notification::whereDate('created_at',$hoy)->where('name','cirugia')->get();
        $cirugias = Cirugia::whereDate('fecha','>=',$hoy)->orderBy('fecha')->get();

        $count = $noti->count();

        if($count == 0){
            $bell = 0;
            return view('cirugias.index', compact('cirugias', 'bell'));
        }else{
            $bell = 1;
            return view('cirugias.index', compact('cirugias', 'bell'));
        }
    }

    public function create()
    {
        return view('cirugias.agendar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'tipo' => 'required',
            'paciente' => 'required',
            'especie' => 'required',
            'propietario' => 'required',
            'telefono' =>  ['required','numeric','digits:8'],
        ]);

        Cirugia::create($request->all());
        return redirect()->route('cirugias.index')->with('success', 'Cirugia ingresada correctamente.');
    }

    public function edit(Cirugia $cirugia)
    {
        return view('cirugias.editar', compact('cirugia'));
    }

    public function update(Request $request, Cirugia $cirugia)
    {
        $request->validate([
            'fecha' => 'required',
            'tipo' => 'required',
            'paciente' => 'required',
            'especie' => 'required',
            'propietario' => 'required',
            'telefono' => ['required','numeric','digits:8'],
        ]);

        $cirugia->update($request->all());
        return redirect()->route('cirugias.index')->with('success', 'Cirugia actualizada correctamente.');
    }

    public function destroy(Cirugia $cirugia)
    {
        $cirugia->delete();
        return redirect()->route('cirugias.index')
            ->with('success', 'Cirugia cancelada correctamente.');
    }

    public function filtrar(Request $request)
    {   
        $fecha = $request['fecha'];
        $filtro = Cirugia::whereDate('fecha',$fecha)->orderBy('fecha')->get();

        $a = count($filtro);

        if ($a > 0) {
            return redirect()->route('cirugias.index')->with('filtro',$filtro);
        }else{
            return redirect()->route('cirugias.index')
            ->with('error', 'No se encontraron resultados en la búsqueda.');
        }

    }
}
