<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = Grupo::all();
        return view('grupos', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semestre' => 'required|integer|min:1|max:12',
            'grupo' => 'required|string|max:1|min:1|unique:grupos,grupo|regex:/^[a-zA-Z0-9]+$/',
            'turno' => 'required|string|max:10|min:1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('grupos.index')->with('error', 'Error al crear el grupo. ' . $validator->errors());
        }
    
        $grupo = new Grupo();
        $grupo->semestre = $request->input('semestre');
        $grupo->grupo = $request->input('grupo');
        $grupo->turno = $request->input('turno');
        $grupo->save();
    
        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
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
        $grupo = Grupo::find($id);
        if ($grupo) {
            return response()->json($grupo);
        } else {
            return response()->json(['message' => 'Grupo no encontrado'], 404);
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
        $validator = Validator::make($request->all(), [
            'semestre' => 'required|integer|min:1|max:12',
            'grupo' => 'required|string|max:2|min:1|unique:grupos,grupo|regex:/^[a-zA-Z0-9]+$/',
            'turno' => 'required|string|max:10|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->route('grupos.index')->with('error', 'Error al actualizar el grupo. ' . $validator->errors());
        }
        $grupo = Grupo::findOrFail($id);
        if (!$grupo) {
            return redirect()->route('grupos.index')->with('error', 'Grupo no encontrado.');
        }
        $grupo->update($request->only(['semestre', 'grupo', 'turno']));
    
        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $grupo = Grupo::find($id);
        if ($grupo) {
            $grupo->delete();
            return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente.');
        } else {
            return redirect()->route('grupos.index')->with('error', 'Grupo no encontrado.');
        }
    }
}
