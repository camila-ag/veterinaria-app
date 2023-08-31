<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class PropietarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function edit(Propietario $propietario ){
        return view('pacientes.editprop', compact('propietario'));
    }

    public function update(Request $request, Propietario $propietario ){
        $request->validate([
            'nombre' => 'required',
            'rut' => ['required','string','min:10','max:10', new ValidChileanRut(new ChileRut)],
            'direccion' => 'required',
            'telefono' => 'required|numeric',
        ]);

        $propietario->update($request->all());
        return redirect()->route('pacientes.index')->with('success', 'Propietario actualizado correctamente.');
    }
}
