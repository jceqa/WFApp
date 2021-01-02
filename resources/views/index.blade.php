@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <h3 class="text-center" style="padding-top: 2%">Analizador de Frecuencia de Palabras</h3>
    <h4 class="text-center">Esta aplicación analiza la cantidad de apariciones de todas las palabras en un texto dado.</h4>
    <div class="card uper">
        <div class="card-header">
        </div>
        <div class="card-body">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br />
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('texto.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="frase">Texto a Analizar</label>
                    <textarea class="form-control" id="frase" rows="4" name="frase"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Analizar</button>
            </form>
        </div>
    </div>
@endsection

