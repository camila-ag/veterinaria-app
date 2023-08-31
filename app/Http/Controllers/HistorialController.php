<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Paciente;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //devuelve la vista para registrar una visita medica
    public function viewRegistrar(Paciente $paciente)
    {
        return view('historial.registrar', compact('paciente'));
    }

    //registra una visita medica
    public function store(Request $request)
    {
        $request->validate([
            'motivo' => 'required',
            'tratamiento' => 'required',
            'fecha' => 'required',
            'peso' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'cc' => 'required|integer|min:1|max:5',
            'paciente_id' => 'required',
            'user_id' => 'required',
        ]);

        Historial::create($request->all());
        
        return redirect()->route('pacientes.show',$request['paciente_id'])->with('success', 'Consulta registrada correctamente.');

    }

    public function edit(Historial $historial){
        $paciente = Paciente::where('id',$historial->paciente_id)->first();
        return view('historial.edit', compact('historial','paciente'));
    }

    public function update(Request $request, Historial $historial){
        $request->validate([
            'motivo' => 'required',
            'tratamiento' => 'required',
            'fecha' => 'required',
            'peso' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'cc' => 'required|integer|min:1|max:5'
        ]);
        $historial->update($request->all());
        return redirect()->route('pacientes.show',$historial->paciente_id);
    }
}
