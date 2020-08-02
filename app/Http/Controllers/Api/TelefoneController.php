<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Telefone;
use App\Http\Requests\TelefoneRequest;

class TelefoneController extends Controller
{
    private $model;
    //private $request;

    function __construct(Telefone $telefone)
    {
        $this->model = $telefone;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TelefoneRequest $request)
    {
        return $this->model->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = $this->model->find($id);

        if (!$entity) {
            return response()->json(['error' => 'Telefone não encontrado'], 404);
        }

        return $entity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TelefoneRequest $request, $id)
    {
        $entity = $this->model->find($id);

        if (!$entity) {
            return response()->json(['error' => 'Telefone não encontrado'], 404);
        }

        $entity->update($request->all());

        return $entity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entity = $this->model->find($id);

        if (!$entity) {
            return response()->json(['error' => 'Telefone não encontrado'], 404);
        }

        $entity->delete();

        return response()->json(null, 204);
    }
}
