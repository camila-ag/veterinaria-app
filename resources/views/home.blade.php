@extends('layouts.layout')

@section('title')
    <title>Inicio | Ayelen</title>
@endsection

@section('content')
<div class="row">
    @php
        $ifcon = count($consultas);
        $ifcir = count($cirugias);
        $ifvac = count($vacunas);
    @endphp

    <div class="col-lg-5 bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 900px;">
        <h4 class="pb-3 border-bottom mb-4 border-dark">Consultas de hoy</h4>
        @if ($ifcon > 0)
            <div class="d-none d-sm-block">
                <table class="table caption-top table-responsive table-bordered border-dark table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Propietario</th>
                            <th>Contacto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--FOREACH-->
                        @foreach ($consultas as $c)
                            <tr>
                                <td>{{$c->hora}}</td>
                                <td>{{$c->paciente}}</td>
                                <td>{{$c->propietario}}</td>
                                <td>+56 9 {{$c->telefono}}</td>
                            </tr>
                        @endforeach
                        <!--FOREACH--> 
                    </tbody>
                </table>

                <div class="text-end">
                    <a href="{{route('consultas.index')}}" class="btn btn-primary">
                        <i class="fa-solid fa-stethoscope"></i>
                        Ver todas
                    </a>
                </div>
            </div>
            <div class="d-sm-none">
                <!--FOREACH-->
                @foreach ($consultas as $c)
                    <dl class="row border-bottom border-dark mt-2 pb-2 px-3">
                        <dt class="col-6">{{$c->hora}}</dt>
                        <dd class="col-6 fw-bold">{{$c->paciente}}</dd>
                        <dt class="col-6 fw-normal">{{$c->propietario}}</dt>
                        <dd class="col-6 fw-normal">+56 9 {{$c->telefono}}</dd>
                    </dl>
                @endforeach
                <!--FOREACH-->

                <div class="text-end">
                    <a href="{{route('consultas.index')}}" class="btn btn-primary">
                        <i class="fa-solid fa-stethoscope"></i>
                        Ver todas
                    </a>
                </div>
            </div>
        @else
            <p>No hay consultas registradas hoy.</p>
        @endif

    </div>
    <div class="col-lg-5 bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 900px;">
        <h4 class="pb-3 border-bottom mb-4 border-dark">Cirugías de hoy</h4>

        @if ($ifcir > 0)
            <div class="d-none d-sm-block">
                <table class="table caption-top table-responsive table-bordered bg-light border-dark table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Paciente</th>
                            <th>Especie</th>
                            <th>Propietario</th>
                            <th>Contacto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--FOREACH-->
                        @foreach ($cirugias as $c)
                            <tr class="text-capitalize">
                                <td>{{$c->paciente}}</td>
                                <td>{{$c->especie}}</td>
                                <td>{{$c->propietario}}</td>
                                <td>+56 9 {{$c->telefono}}</td>

                            </tr>
                        @endforeach
                        <!--FOREACH-->
                    </tbody>
                </table>
                <div class="text-end">
                    <a href="{{route('cirugias.index')}}" class="btn btn-primary">
                        <i class="fa-solid fa-heart-pulse"></i>
                        Ver todas
                    </a>
                </div>
            </div>

            <div class="d-sm-none">
                <!--FOREACH-->
                @foreach ($cirugias as $c)
                    <dl class="row border-bottom border-dark mt-2 pb-2 px-3 text-capitalize">
                        <dt class="col-6">{{$c->paciente}}</dt>
                        <dd class="col-6 fw-bold">{{$c->especie}}</dd>
                        <dt class="col-6 fw-normal">{{$c->propietario}}</dt>
                        <dd class="col-6 fw-normal">+56 9 {{$c->telefono}}</dd>
                    </dl>
                @endforeach

                <!--FOREACH-->
                <div class="text-end">
                    <a href="{{route('cirugias.index')}}" class="btn btn-primary">
                        <i class="fa-solid fa-heart-pulse"></i>
                        Ver todas
                    </a>
                </div>
            </div>
        @else
            <p>No hay cirugias registradas hoy.</p>
        @endif

    </div>

    <div class="col-lg-11 bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 1530px;">
        @if ($ifvac > 0)
            <div class="row border-bottom border-dark pb-2 mb-4">
                <div class="col-md-6">
                    <h4 class="">Próximas vacunas</h4>
                </div>
                <div class="col-md-6 text-md-end">
                    @if ($bell == 0)
                        <form action="{{route('avisar')}}" method="POST">
                            @csrf
                            <button class="btn btn-primary"><i class="fa-solid fa-bell me-2"></i>Enviar recordatorios</button>
                        </form>
                    @else
                        <form action="{{route('avisar')}}" method="POST">
                            @csrf
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ya se enviaron recordatorios">
                                <button class="btn btn-primary" type="button" disabled><i class="fa-solid fa-bell me-2"></i>Enviar recordatorios</button>
                            </span>
                        </form>
                    @endif 
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="col-md-12">
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="col-md-12">
                    <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-3" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                        <div>
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        
            <table class="table caption-top table-responsive table-bordered bg-light border-dark table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha administración</th>
                        <th>Paciente</th>
                        <th>Propietario</th>
                        <th>Vacuna</th>
                        <th>Próxima dosis</th>
                    </tr>
                </thead>
                <tbody>
                    <!--FOREACH-->
                    @foreach ($vacunas as $v)
                        <tr class="text-capitalize">
                            <td class="col-2">{{date("d/m/Y", strtotime($v->fecha_adm))}}</td>
                            <td>{{ucwords(strtolower($v->paciente))}}</td>
                            <td>{{ucwords(strtolower($v->propietario))}}</td>
                            <td class="col-3">{{$v->vacuna}}, {{$v->marca}}</td>
                            <td>{{date("d/m/Y", strtotime($v->fecha_prox))}}</td>
                        </tr>
                    @endforeach
                    <!--FOREACH-->
                </tbody>
            </table>
        @else
            <h4 class="pb-3 border-bottom mb-4 border-dark">Próximas vacunas</h4>
            <p>No hay vacunas próximas.</p>
        @endif
    </div>

</div>
@endsection
