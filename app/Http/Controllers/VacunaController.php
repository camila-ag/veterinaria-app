<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Vacuna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Propietario;
use Twilio\Rest\Client;

class VacunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function nuevaVacuna(Paciente $paciente)
    {
        return view('historial.vacuna', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vacuna' => 'required',
            'marca' => 'required',
            'obs' => 'required',
            'fecha_adm' => 'required',
            'fecha_prox' => 'required',
            'paciente_id' => 'required',
            'user_id' => 'required',
        ]);

        Vacuna::create($request->all());
        
        return redirect()->route('pacientes.show',$request['paciente_id'])->with('success', 'Vacuna registrada correctamente.');

    }


    public function enviarAvisos()
    {
        $fecha = Carbon::now()->addDay();
        $fecha->locale();
        
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        $vacunas = Vacuna::join('pacientes','vacunas.paciente_id','=','pacientes.id')
        ->join('propietarios','pacientes.propietario_rut','=','propietarios.rut')
        ->select('vacunas.fecha_prox','pacientes.nombre as paciente','propietarios.telefono')
        ->whereDate('vacunas.fecha_prox',$fecha)
        ->get();

        $c = $vacunas->count();

        if($c > 0){
            foreach($vacunas as $v){
                $to = "+569".$v->telefono;
                //print($to);
                $twilio->messages 
                      ->create($to, // to 
                               array(  
                                   "from" => "MG0da3b45bb8e42ca1df2dfae292e0e90c",      
                                   "body" => "Veterinaria Ayelen te recuerda que se acerca la próxima vacuna de {$v->paciente} el día {$fecha->dayName} {$fecha->day} de {$fecha->monthName}, recuerda agendar una hora al número +56971326967." 
                               ) 
                      ); 
            }
    
            Notification::create(
                ['name' => 'vacuna']
            );
    
            return redirect()->back()
                ->with('success', 'Recordatorios enviados correctamente.');
        
        }else{
            return redirect()->back()
                ->with('error', 'No hay vacunas próximas.');
        }
        
    }

    public function edit(Vacuna $vacuna){
        $paciente = Paciente::where('id',$vacuna->paciente_id)->first();
        return view('historial.editvacuna', compact('vacuna','paciente'));
    }

    public function update(Request $request, Vacuna $vacuna){
        $request->validate([
            'fecha_adm' => 'required',
            'fecha_prox' => 'required',
            'vacuna' => 'required',
            'marca' => 'required',
            'obs' => 'required',
        ]);
        $vacuna->update($request->all());
        return redirect()->route('pacientes.show',$vacuna->paciente_id);
    }

}
