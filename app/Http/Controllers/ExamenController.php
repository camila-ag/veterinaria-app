<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Paciente;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewExamen(Paciente $paciente){
        return view('historial.examen', compact('paciente'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
            'examen' => 'required',
            'paciente_id' => 'required',
        ]);
        $data = $request->all();
        $examen = $request->file('examen');
        $nombre = "examen_".time()."_".$request['paciente_id'].".".$examen->guessExtension();
        $ruta = public_path("examenes/".$nombre);
        copy($examen,$ruta);
        $data['examen'] = $nombre;
        Examen::create($data);
        return redirect()->route('pacientes.show',$request['paciente_id'])->with('success', 'Examen registrado correctamente.');
        
        
    }
}
