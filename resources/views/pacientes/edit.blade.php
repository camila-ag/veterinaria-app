@extends('layouts.layout')

@section('title')
    <title>Actualizar paciente | Ayelen</title>
@endsection

@section('content')
<form action="{{route('pacientes.update', $paciente->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-4 bg-light border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 1000px;">
        <h4 class="pb-3 border-bottom border-dark">Actualizar paciente</h4>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="nombre" class="col-sm-4 col-form-label">Nombre</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{$paciente->nombre}}" name="nombre" id="nombre"
                    placeholder="Ingrese nombre">
                    @error('nombre')
                        <div id="nombre" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="chip" class="col-sm-4 col-form-label text-nowrap">N° de microchip</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('chip') is-invalid @enderror" value="{{$paciente->chip}}" name="chip" id="chip"
                    placeholder="Ingrese microchip">
                    @error('chip')
                        <div id="chip" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="nacimiento" class="col-sm-4 col-form-label text-nowrap">Nacimiento</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control @error('nacimiento') is-invalid @enderror" value="{{$paciente->nacimiento}}" name="nacimiento" id="nacimiento" required>
                    @error('nacimiento')
                        <div id="nacimiento" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="especie" class="col-sm-4 col-form-label text-nowrap">Especie</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('especie') is-invalid @enderror" value="{{$paciente->especie}}" name="especie" id="especie" required>
                    @error('especie')
                        <div id="especie" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="raza" class="col-sm-4 col-form-label text-nowrap">Raza</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('raza') is-invalid @enderror" value="{{$paciente->raza}}" name="raza" id="raza" required>
                    @error('raza')
                        <div id="raza" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="sexo" class="col-sm-4 col-form-label text-nowrap">Sexo</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('sexo') is-invalid @enderror" value="{{$paciente->sexo}}" name="sexo" id="sexo" required>
                    @error('sexo')
                        <div id="sexo" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="peso" class="col-sm-4 col-form-label text-nowrap">Peso</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('peso') is-invalid @enderror" value="{{$paciente->peso}}" name="peso" id="peso" required>
                    @error('peso')
                        <div id="peso" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        
        <button class="btn btn-primary mt-1" style="max-width: 400px;">Actualizar</button>
    
    </div>
</form>


@endsection