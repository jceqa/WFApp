@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="uper">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <h4 class="text-center">Tabla de Frecuencias de Palabras</h4>
        <div class="text-center"><span><strong>Texto</strong> : "{{$texto->frase}}"</span></div>
        <div style="text-align:center;">
            <table class="table table-striped" style="width: fit-content;margin: 0 auto;">
                <thead>
                    <tr>
                        <td class="text-center">Palabra</td>
                        <td class="text-center">Cantidad de Apariciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($frecuencia as $fec)
                        <tr>
                            <td class="text-center">{{$fec->palabra}}</td>
                            <td class="text-center">{{$fec->repeticiones}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="display: inline-block">
                {{ $frecuencia->links("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
    {!! $chart->container() !!}
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <a href="{{ route('texto.index')}}" class="btn btn-primary float-right">Atrás</a>
@endsection
