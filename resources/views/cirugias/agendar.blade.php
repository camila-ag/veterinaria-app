@extends('layouts.layout')

@section('title')
    <title>Agendar cirugia | Ayelen</title>
@endsection

@section('content')

<div class="bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 900px;">
    <h4 class="pb-3 border-bottom mb-4 border-dark">Agendar cirugia</h4>
    
    <form action="{{route('cirugias.store')}}" method="POST">
        @csrf
        <div class="row mt-4 mx-auto" style="max-width:800px;">
            <label for="mot" class="col-md-2 col-form-label">Fecha</label>
            <div class="col-md-4 mb-3">
                <input type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" id="fecha" value="{{old('fecha')}}">
                @error('fecha')
                    <div id="fecha" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <label for="tipo" class="col-md-2 col-form-label">Tipo</label>
            <div class="col-md-4 mb-3">
                <input type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" id="tipo" value="{{old('tipo')}}">
                @error('tipo')
                    <div id="tipo" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="paciente" class="col-md-2 col-form-label">Paciente</label>
            <div class="col-md-4 mb-3">
                <input type="text" name="paciente" id="paciente" class="form-control @error('paciente') is-invalid @enderror" value="{{old('paciente')}}">
                @error('paciente')
                    <div id="paciente" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="especie" class="col-md-2 col-form-label">Especie</label>
            <div class="col-md-4 mb-3">
                <input type="text" name="especie" id="especie" class="form-control @error('especie') is-invalid @enderror" value="{{old('especie')}}">
                @error('especie')
                    <div id="especie" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="propietario" class="col-md-2 col-form-label">Propietario</label>
            <div class="col-md-4 mb-3">
                <input type="text" name="propietario" id="propietario" class="form-control @error('propietario') is-invalid @enderror" value="{{old('propietario')}}">
                @error('propietario')
                    <div id="propietario" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="telefono" class="col-md-2 col-form-label">Telefono</label>
            <div class="col-md-4 mb-3">
                <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{old('telefono')}}">
                @error('telefono')
                    <div id="telefono" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <div class="col-2 mt-2">
                <a href="{{URL::previous()}}" class="btn btn-outline-primary">Volver</a>
            </div>
    
            <div class="col-4 mx-auto mt-2">
                <button class="btn btn-primary">Agendar</button>
            </div>

            @if ($message = Session::get('error'))
                <div class="col-md-12 mt-3">
                    <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-3" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                        <div>
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

        </div>
    </form>

</div>

@endsection