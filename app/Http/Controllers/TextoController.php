<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Frecuencia;
use App\Models\Texto;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class TextoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        //return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request): Application|RedirectResponse|Redirector
    {
        $validatedData = $request->validate([
            'frase' => 'required|max:2048',
        ]);

        $texto = Texto::create($validatedData);

        $palabras = preg_split("/[\s,\s.]+/", $texto->frase);

        $size = count($palabras);
        $pal = "";
        $p="";
        $f="";
        $frecuencias = Array();
        foreach ($palabras as $palabra){
            $cant = 0;
            $rep = strpos($pal, $palabra);
            if($rep === false) {
                for($i = 0; $i < $size; $i++){
                    if(!empty($palabra) && $palabra != "" && strtolower($palabra) === strtolower($palabras[$i])) {
                        $cant++;
                    }
                }
                $frecuencias[] = array(
                    'palabra' => strtolower($palabra),
                    'repeticiones' => $cant,
                    'id_texto' => $texto->id
                );
                $pal .= strtolower($palabra);
                $p .= "'".strtolower($palabra)."',";
                $f .= strval($cant).",";
            }
        }
        $p = substr($p, 0, -1);
        $f = substr($f, 0, -1);
        $p .= "";
        $f .= "";

        $texto->palabras = $p;
        $texto->frecuencias = $f;
        $texto->save();

        Frecuencia::insert($frecuencias);

        //return redirect('/texto')->with('success', 'El texto fue analizado correctamente');
        return redirect()->action([TextoController::class, 'show'], $texto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $texto = Texto::where('id', '=', $id)->first();

        $frecuencia = Frecuencia::where('id_texto', '=', $id)->orderBy('repeticiones', 'DESC')->paginate(5);

        $chart = (new LarapexChart)->setTitle('')
            ->setDataset(array_map('intval', explode(",",$texto->frecuencias)))
            ->setLabels(explode(",",$texto->palabras));

        return view('result',compact('texto', 'frecuencia', 'chart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
