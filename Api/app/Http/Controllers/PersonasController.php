<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Traits\RespuestaAPI;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;


class PersonasController extends Controller
{
    use RespuestaAPI;

    protected $reglas =
    [
        'nombre' => 'required|string|max:60',
        'apellido' => 'required|string|max:60',
        'email' => 'required|string|max:255',
        'telefono' => 'required|integer|max:60',
        'direccion' => 'required|string|max:60',
        'ciudad' => 'required|string|max:60',
        'pais' => 'required|string|max:60',
        'codigo_postal' => 'required|string|max:10',
        'estado' => 'required|string|max:50',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persona=Persona::all();
        return response()->json($persona);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Se valida la solicitud
        $validacion = Validator::make($request->all(), $this->reglas);
        //Si la validacion falla, se retorna un error
        if ($validacion->fails()) 
            return $this->error($validacion->errors(), 422);
        
        //Si la validacion no falla, se crea el registro
        
        $persona = Persona::create($validacion->validated());
        return $this->exito(['persona'=>$persona]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        //Se valida la solicitud
        $validacion = Validator::make($request->all(), $this->reglas);

        //Si la validacion falla, se retorna un error
        if ($validacion->fails()) 
            return $this->error($validacion->errors());

        //Si la validacion no falla, se actualiza el registro
        $persona->update($validacion->validated());
        return $this->exito(['persona'=>$persona]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return $this->exito(['persona'=>$persona]);
         
    }
}
