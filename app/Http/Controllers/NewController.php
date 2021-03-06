<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreNewRequest;
use App\Http\Requests\UpdateNewRequest;
use App\Neww;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Neww::all(), 200); // 200: OK
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewRequest $request)
    {
        // NOTA: Si se va a probar la API en Postman, es necesario quitar este if
        if($request->ajax()){ 
            $neww = Neww::Create($request->validated());

            return response()->json($neww, 201); // 201: Created    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Neww::findOrFail($id), 200); // 200: OK
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewRequest $request, $id)
    {
        $neww = Neww::findOrFail($id);
        $neww->update($request->all());
    
        return response()->json($neww, 200); // 200: OK
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Neww::findOrFail($id)->delete(), 204); // 204: No Conent 
    }
}
