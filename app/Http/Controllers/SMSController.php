<?php

namespace App\Http\Controllers;

use App\Models\Cirugia;
use App\Models\Consulta;
use App\Models\Notification;
use Carbon\Carbon;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function notiConsultas()
    {
        $fecha = Carbon::now()->addDay();
        $fecha->locale();
        
        $consultas = Consulta::whereDate('fecha',$fecha)->get();
        
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        $c = $consultas->count();

        if($c > 0){
            foreach($consultas as $c){
                $to = "+569".$c->telefono;
                $hora = $c->hora;
    
                $twilio->messages 
                      ->create($to, // to 
                               array(  
                                   "from" => "MG0da3b45bb8e42ca1df2dfae292e0e90c",      
                                   "body" => "Recuerda la consulta de {$c->paciente} el dia {$fecha->dayName} {$fecha->day} de {$fecha->monthName} a las {$hora} hrs. en Veterinaria Ayelen. Para cancelar o reagendar la cita comunicarse al +56971326967." 
                               ) 
                      ); 
            }
    
            Notification::create(
                ['name' => 'consulta']
            );
    
            return redirect()->route('consultas.index')
                ->with('success', 'Recordatorios enviados correctamente.');
        
        }else{
            return redirect()->route('consultas.index')
                ->with('error', 'No hay consultas agendadas para mañana.');
        }
        
    }

    public function notiCirugias()
    {
        $fecha = Carbon::now()->addDay();
        $fecha->locale();
        
        $cirugias = Cirugia::whereDate('fecha',$fecha)->get();
        
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        $c = $cirugias->count();

        if($c > 0){
            foreach($cirugias as $c){
                $to = "+569".$c->telefono;
    
                $twilio->messages 
                      ->create($to, // to 
                               array(  
                                   "from" => "MG0da3b45bb8e42ca1df2dfae292e0e90c",      
                                   "body" => "Recuerda la cita de {$c->paciente} el dia {$fecha->dayName} {$fecha->day} de {$fecha->monthName} en Veterinaria Ayelen. Para cancelar o reagendar la cita comunicarse al +56971326967." 
                               ) 
                      ); 
            }
    
            Notification::create(
                ['name' => 'cirugia']
            );
    
            return redirect()->route('consultas.index')
                ->with('success', 'Recordatorios enviados correctamente.');
        
        }else{
            return redirect()->route('consultas.index')
                ->with('error', 'No hay consultas agendadas para mañana.');
        }
        
    }
}