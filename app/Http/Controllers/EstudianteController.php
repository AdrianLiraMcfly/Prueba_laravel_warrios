<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Grupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource along with groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('estudiantes', compact('estudiantes', 'grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required | string | max:50 | min:2 | regex:/^[a-zA-Z ]+$/',
            'apellido' => 'required | string | max:50 | min:2 | regex:/^[a-zA-Z ]+$/',
            'edad' => 'required | integer | min:1 | max:100',
            'email' => 'required | email | max:50 | min:5 | unique:estudiantes',
            'telefono' => 'required | string | max:10',
            'grupo_id' => 'required | integer | exists:grupos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('estudiantes.index')->with('error', 'Error al crear el estudiante ' . $validator->errors());
        }

        $estudiante = new Estudiante();
        $estudiante->nombre = $request->nombre;
        $estudiante->apellido = $request->apellido;
        $estudiante->edad = $request->edad;
        $estudiante->email = $request->email;
        $estudiante->telefono = $request->telefono;
        $estudiante->grupo_id = $request->grupo_id;
        $estudiante->save();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estudiante = Estudiante::find($id);
        if ($estudiante) {
            return response()->json($estudiante);
        } else {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }
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
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);
        if ($estudiante) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:50|min:2|regex:/^[a-zA-Z ]+$/',
                'apellido' => 'required|string|max:50|min:2|regex:/^[a-zA-Z ]+$/',
                'edad' => 'required|integer|min:1|max:100',
                'email' => [
                    'required',
                    'email',
                    'max:50',
                    'min:5',
                    'email:rfc,dns',
                    Rule::unique('estudiantes')->ignore($estudiante->id),
                ],
                'telefono' => 'required|string|max:10',
                'grupo_id' => 'required|integer|exists:grupos,id',
            ]);

            if ($validator->fails()) {
                return redirect()->route('estudiantes.index')->with('error', 'Error al actualizar el estudiante ' . $validator->errors());
            }

            $estudiante->nombre = $request->nombre;
            $estudiante->apellido = $request->apellido;
            $estudiante->edad = $request->edad;
            $estudiante->email = $request->email;
            $estudiante->telefono = $request->telefono;
            $estudiante->grupo_id = $request->grupo_id;
            $estudiante->save();

            return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente');
        } else {
            return r¿edirect()->route('estudiantes.index')->with('error', 'Estudiante no encontrado');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $estudiante=Estudiante::find($id);
        $estudiante->delete();
        if ($estudiante) {
            return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente');
        } else {
            return redirect()->route('estudiantes.index')->with('error', 'Error al eliminar el estudiante');
        }
    }
}
