@extends('layouts.layout')

@section('title')
    <title>Registrar vacuna | Ayelen</title>
@endsection

@section('content')

<div class="bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 900px;">
    <h4 class="pb-3 border-bottom mb-4 border-dark">Registrar vacuna</h4>
    
    <form action="{{route('vacuna.store')}}" method="POST">
        @csrf
        <div class="row mt-4 mx-auto" style="max-width:800px;">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="hidden" name="paciente_id" value="{{$paciente->id}}">
            <label for="mot" class="col-md-2 col-form-label">Paciente</label>
            <div class="col-md-4 mb-3">
                <input type="text" readonly class="form-control" id="pac" value="{{ucfirst($paciente->nombre)}}">
            </div>

            <label for="fecha_adm" class="col-md-2 col-form-label">Administración</label>
            <div class="col-md-4 mb-3">
                <input type="date" class="form-control @error('fecha_adm') is-invalid @enderror" value="{{ old('fecha_adm') }}" name="fecha_adm" id="fecha_adm"
                required>
                @error('fecha_adm')
                    <div id="fecha_adm" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="vacuna" class="col-md-2 col-form-label">Vacuna</label>
            <div class="col-md-4 mb-3">
                <input type="text" class="form-control @error('vacuna') is-invalid @enderror" value="{{ old('vacuna') }}" name="vacuna" id="vacuna"
                placeholder="Ingrese nombre" required>
                @error('vacuna')
                    <div id="vacuna" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="marca" class="col-md-2 col-form-label">Marca</label>
            <div class="col-md-4 mb-3">
                <input type="text" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca') }}" name="marca" id="marca"
                placeholder="Ingrese marca" required>
                @error('marca')
                    <div id="marca" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <label for="obs" class="col-md-2 col-form-label">Observaciones</label>
            <div class="col-md-4 mb-3">
                <textarea name="obs" id="obs" class="form-control @error('obs') is-invalid @enderror"
                placeholder="Ingrese observaciones">{{old('obs')}}</textarea>
                @error('obs')
                    <div id="obs" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <label for="fecha_prox" class="col-md-2 col-form-label">Próxima dosis</label>
            <div class="col-md-4 mb-3">
                <input type="date" class="form-control @error('fecha_prox') is-invalid @enderror" value="{{ old('fecha_prox') }}" name="fecha_prox" id="fecha_prox"
                required>
                @error('fecha_prox')
                    <div id="fecha_prox" class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
    
            <div class="text-center">
                <button class="btn btn-primary">Registrar vacuna</button>
            </div>
        </div>
    </form>


</div>

@endsection