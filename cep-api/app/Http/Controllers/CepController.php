<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cep;

class CepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cep::orderBy('created_at', 'asc')->get();  //returns values in ascending order
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cep'         => 'required',
            'logradouro'  => 'required',
            'complemento' => 'nullable',
            'bairro'      => 'required',
            'cidade'      => 'required',
            'uf'          => 'required',
        ]);

        $cep = new Cep;
        $cep->cep = $request->input('cep');
        $cep->logradouro = $request->input('logradouro');
        $cep->complemento = $request->input('complemento');
        $cep->bairro = $request->input('bairro');
        $cep->cidade = $request->input('cidade');
        $cep->uf = $request->input('uf');
        $cep->save();

        return $cep;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cep)
    {
        $data = Cep::findorFail($cep);

        if (!$data) {
            $data = Http::get('https://viacep.com.br/ws/' . $cep . '/json/')->json;
        }

        return $data;

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
        $this->validate($request, [
            'cep'         => 'required',
            'logradouro'  => 'required',
            'complemento' => 'nullable',
            'bairro'      => 'required',
            'cidade'      => 'required',
            'uf'          => 'required',
        ]);

        $cep = Cep::findorFail($id);
        $cep->cep = $request->input('cep');
        $cep->logradouro = $request->input('logradouro');
        $cep->complemento = $request->input('complemento');
        $cep->bairro = $request->input('bairro');
        $cep->cidade = $request->input('cidade');
        $cep->uf = $request->input('uf');
        $cep->save();

        return $cep;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cep = Cep::findorFail($id);

        if ($cep->delete()) {
            return 'Apagado com sucesso';
        }
    }

    /**
     * Display CEPs that have part of logradouro.
     *
     * @param  string  $logradouro
     * @return \Illuminate\Http\Response
     */
    public function search($logradouro)
    {
        return Cep::query()
                    ->where('logradouro', 'LIKE', "%{$logradouro}%")->get();
    }
}
