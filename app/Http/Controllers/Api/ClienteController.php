<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;

use Image;
use Storage;

class ClienteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        // dd($clientes);
        return $clientes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        //
        //dd($request->all());
        //dd($request->image);
        $dataForm = $request->all();

        // $this->validate($request, Cliente::ru)
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            //$name = uniqid("luciano");
            $nameFile = "{$name}.{$extension}";

            // $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/{$nameFile}", 70));
            $upload = Image::make($request->image)->resize(177, 236, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path("app/public/clientes/{$nameFile}", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
                // $dataForm['image'] = asset("storage/clientes/$nameFile");
            }
        }

        //dd($dataForm['image']);

        $cliente = Cliente::create($dataForm);

        //return response()->json($cliente, 200, [], JSON_UNESCAPED_SLASHES);



        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        return $cliente;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        $cliente = Cliente::find($id);

        $request->replace($request->all());
        dd($request->all(), $_FILES);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        $dataForm = $request->all();

        // $this->validate($request, Cliente::ru)
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            //verificar se ja tem uma imagem e apagar do disco
            if ($cliente->image) {
                Storage::disk('public')->delete("/clientes/$cliente->image");
            }


            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            //$name = uniqid("luciano");
            $nameFile = "{$name}.{$extension}";

            // $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/{$nameFile}", 70));
            $upload = Image::make($request->image)->resize(177, 236, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path("app/public/clientes/{$nameFile}", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
                // $dataForm['image'] = asset("storage/clientes/$nameFile");
            }
        }

        $cliente->update($dataForm);

        //dd($request->all());
        //$cliente->nome = $request->nome;
        //$cliente->save();

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        if ($cliente->image) {
            Storage::disk('public')->delete("/clientes/$cliente->image");
        }

        $cliente->delete();

        return response()->json(null, 204);

        // return response()->json(['success' => 'Deletado com sucesso!']);
    }
}
