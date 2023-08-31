<?php

namespace App\Http\Controllers;

use App\Models\Cirugia;
use App\Models\Consulta;
use App\Models\Notification;
use App\Models\Vacuna;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hoy = Carbon::today();
        $consultas = Consulta::whereDate('fecha',$hoy)->orderBy('hora')->get();
        $cirugias = Cirugia::whereDate('fecha',$hoy)->get();        

        $tomorrow = Carbon::now()->addDay();
        $vacunas = Vacuna::whereDate('fecha_prox',$tomorrow)->get();

        $vacunas = Vacuna::join('pacientes','vacunas.paciente_id','=','pacientes.id')
        ->join('propietarios','pacientes.propietario_rut','=','propietarios.rut')
        ->select('vacunas.*','pacientes.nombre as paciente','propietarios.nombre as propietario')
        ->whereDate('vacunas.fecha_prox',$tomorrow)
        ->get();

        $noti = Notification::whereDate('created_at',$hoy)->where('name','vacuna')->get();
        $count = $noti->count();

        if($count == 0){
            $bell = 0;
            return view('home',compact('consultas','cirugias','vacunas','bell'));
        }else{
            $bell = 1;
            return view('home',compact('consultas','cirugias','vacunas','bell'));
        }

    }
}
