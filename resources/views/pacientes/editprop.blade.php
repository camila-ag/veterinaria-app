@extends('layouts.layout')

@section('title')
    <title>Actualizar propietario| Ayelen</title>
@endsection

@section('content')
<form action="{{route('propietarios.update',$propietario->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-4 bg-light border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 1000px;">
        <h4 class="pb-3 border-bottom mb-4 border-dark">Datos propietario</h4>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ $propietario->nombre }}" name="nombre" id="nombre"
                    placeholder="Ingrese nombre" required>
                    @error('nombre')
                        <div id="nombre" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="rut" class="col-sm-3 col-form-label">Rut</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('rut') is-invalid @enderror" value="{{ $propietario->rut }}" name="rut" id="rut" 
                    placeholder="Rut sin puntos y con guión" required>
                    @error('rut')
                        <div id="rut" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="num" class="col-sm-3 col-form-label">Telefono</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{ $propietario->telefono }}" name="telefono" id="telefono"
                    placeholder="Ingrese teléfono" required>
                    @error('telefono')
                        <div id="telefono" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3 row">
                <label for="prop" class="col-sm-3 col-form-label">Dirección</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" value="{{ $propietario->direccion }}" name="direccion" id="direccion"
                    placeholder="Ingrese dirección" required>
                    @error('direccion')
                        <div id="direccion" class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-4" style="max-width: 400px;">Actualizar propietario</button>
    
    </div>
</form>


@endsection