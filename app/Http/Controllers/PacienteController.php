<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Historial;
use App\Models\Notification;
use App\Models\Paciente;
use App\Models\Propietario;
use App\Models\User;
use App\Models\Vacuna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Listado de pacientes
    public function index()
    {
        $hoy = Carbon::today();
        $noti = Notification::whereDate('created_at',$hoy)->where('name','vacuna')->get();
        $propietarios = Propietario::with('pacientes')->paginate(10);

        $count = $noti->count();

        if($count == 0){
            $bell = 0;
            return view('pacientes.index',compact('propietarios','bell'));
        }else{
            $bell = 1;
            return view('pacientes.index',compact('propietarios','bell'));
        }
        
    }

    //Buscar por nombre del paciente
    public function nombrePaciente(Request $request)
    {
        $request->validate([
            'paciente' => 'required',
        ]);

        $data = $request->paciente;
        $prop = Propietario::with(['pacientes'=>function($query)use($data){
            $query->where('nombre','like','%'.$data.'%');
        }])->get();

        $a = count($prop);

        if ($a > 0) {
            return redirect()->route('pacientes.index')->with('npaciente',$prop);
        }else{
            return redirect()->route('pacientes.index')
            ->with('error', 'No se encontraron resultados en la búsqueda.');
        }
    }

    //buscar por nombre del propietario
    public function nombrePropietario(Request $request)
    {
        $request->validate([
            'propietario' => 'required',
        ]);

        $buscarPropietario = Propietario::where('nombre','like','%'.$request->propietario.'%')
        ->with('pacientes')            
        ->get();

        $a = count($buscarPropietario);

        if ($a > 0) {
            return redirect()->route('pacientes.index')->with('buscar',$buscarPropietario);
        }else{
            return redirect()->route('pacientes.index')
            ->with('error', 'No se encontraron resultados en la búsqueda.');
        }
    }

    //buscar por rut del propietario
    public function rutPropietario(Request $request)
    {
        $request->validate([
            'rut' => ['required','string','min:10','max:10', new ValidChileanRut(new ChileRut)],
        ]);

        $buscarPropietario = Propietario::where('rut',$request->rut)
        ->with('pacientes')            
        ->get();

        $a = count($buscarPropietario);

        if ($a > 0) {
            return redirect()->route('pacientes.index')->with('buscar',$buscarPropietario);
        }else{
            return redirect()->route('pacientes.index')
            ->with('error', 'No se encontraron resultados en la búsqueda.');
        }
    }

    //Devuelve la vista para ingresar un paciente nuevo y propietario nuevo
    public function create()
    {
        return view('pacientes.nuevo');
    }

    //Guarda el nuevo paciente y propietario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombreprop' => 'required',
            'rut' => ['required','string','unique:propietarios', new ValidChileanRut(new ChileRut)],
            'telefono' => ['required','numeric','digits:8'],
            'direccion' => 'required',
            'nombrepac' => 'required',
            'nacimiento' => 'required',
            'especie' => 'required',
            'raza' => 'required',
            'sexo' => 'required',
            'peso' => 'required|numeric|between:0.00,99.99',
        ]);

        Propietario::create([
            'nombre' => $request['nombreprop'],
            'rut' => $request['rut'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
        ]);

        Paciente::create([
            'nombre' => $request['nombrepac'],
            'nacimiento' => $request['nacimiento'],
            'especie' => $request['especie'],
            'raza' => $request['raza'],
            'sexo' => $request['sexo'],
            'peso' => $request['peso'],
            'propietario_rut' => $request['rut']
        ]);

        $id = Paciente::latest('id')->select('id')->first();
        return redirect()->route('pacientes.show',$id);
    }

    //Devuelve la vista para ingresar un paciente cuyo propietario ya existe
    public function viewExistente()
    {   
        $propietarios = Propietario::get();
        return view('pacientes.existente', compact('propietarios'));
    }

    //Buscar el rut del propietario existente
    public function buscarPropietario(Request $request)
    {
        $request->validate([
            'rut' => ['required','string','min:10','max:10', new ValidChileanRut(new ChileRut)],
        ]);

        $propietario = Propietario::where('rut',$request->rut)->first();

        return redirect()->route('pacientes.existente')->with('prop',$propietario);
    }

    //Guardar el paciente del propietario existente
    public function storeExistente(Request $request)
    {
        $validador = Validator::make($request->all(),[
            'nombre' => 'required',
            'nacimiento' => 'required',
            'especie' => 'required',
            'raza' => 'required',
            'sexo' => 'required',
            'peso' => 'required|numeric|between:0.00,99.99',
            'propietario_rut' => 'required'
        ]);

        $rut = $request['propietario_rut'];
        $propietario = Propietario::where('rut',$rut)->first();

        if($validador->fails()){
            return redirect()->route('pacientes.existente')->with('prop',$propietario)->withErrors($validador)->withInput();
        }else{
            Paciente::create($request->all());
            $id = Paciente::latest('id')->select('id')->first();
            return redirect()->route('pacientes.show',$id);
        }

    }

    //revisar un paciente
    public function show(Paciente $paciente)
    {
        $historial = Historial::join('users','historial.user_id','=','users.id')->where('historial.paciente_id',$paciente->id)
        ->select('historial.*','users.name as veterinario')
        ->orderBy('fecha','desc')
        ->get();

        $vacunas = Vacuna::join('users','vacunas.user_id','=','users.id')->where('vacunas.paciente_id',$paciente->id)
        ->select('vacunas.*','users.name as veterinario')
        ->orderBy('fecha_adm','desc')
        ->get();

        $examenes = Examen::where('paciente_id',$paciente->id)
        ->orderBy('created_at','desc')
        ->get();

        $propietario = Propietario::where('rut',$paciente->propietario_rut)->first();

        return view('pacientes.revisar',compact('paciente','historial','propietario','vacunas','examenes'));
    }

    public function edit(Paciente $paciente ){
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente){
        $request->validate([
            'chip' => ['nullable','digits:15','unique:pacientes'],
            'nombre' => 'required',
            'nacimiento' => 'required',
            'especie' => 'required',
            'raza' => 'required',
            'sexo' => 'required',
            'peso' => 'required|numeric|between:0.00,99.99',
        ]);

        $paciente->update($request->all());
        return redirect()->route('pacientes.show',$paciente->id);
    }

}
