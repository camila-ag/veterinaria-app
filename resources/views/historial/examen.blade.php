@extends('layouts.layout')

@section('title')
    <title>Registrar examen a {{$paciente->nombre}} | Ayelen</title>
@endsection

@section('content')
    <div class="bg-light mt-4 border border-dark p-md-4 p-2 rounded mx-auto justify-content-evenly" style="max-width: 900px;">
        <h4 class="pb-3 border-bottom mb-4 border-dark">Registrar examen</h4>
        <form action="{{route('examen.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4 mx-auto" style="max-width:800px;">
                @csrf
                <div class="row mt-4 mx-auto" style="max-width:800px;">
                    <input type="hidden" name="paciente_id" value="{{$paciente->id}}">
                    <label for="paciente" class="col-md-2 col-form-label">Paciente</label>
                    <div class="col-md-10 mb-3">
                        <input type="text" readonly class="form-control" id="paciente" value="{{ucfirst($paciente->nombre)}}">
                    </div>
        
                    <label for="nombre" class="col-md-2 col-form-label">Examen</label>
                    <div class="col-md-10 mb-3">
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" name="nombre" id="nombre"
                        required>
                        @error('nombre')
                            <div id="nombre" class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <label for="file" class="col-md-2 col-form-label">Archivo</label>
                    <div class="col-md-10 mb-3">
                        <input class="form-control" type="file" id="formFile" name="examen">
                        @error('examen')
                            <div id="examen" class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>                    
                <button type="submit" class="btn btn-primary w-50 mx-auto">Registrar</button>
            </div>                               
        </form>
    </div>
    
@endsection