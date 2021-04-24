<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.productos');
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
        $validator = Validator::make($request->all(),[
            'nombre'=>'required|max:255|min:1',
            'descripcion'=>'required|max:255|min:1',
            'stock'=>'required|max:255|min:1|numeric',
            'precio'=>'required|max:255|min:1|numeric',
            'tags'=>'required|max:255|min:1',
            'imagen'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return back()
            ->withInput()
            ->with('errorInsert', 'Favor de llenar todos los campos')
            ->withErrors('Favor de llenar los campos');
        }else{
            $imagen=$request->file('imagen');
            $nombre=time().'.'.$imagen->getClientOriginalExtension();
            $destino=public_path('images/productos');
            $request->imagen->move($destino.'/'.$nombre);
            $producto = Product::create([
                'name'=>request()->nombre,
                'description'=>request()->descripcion,
                'stock'=>request()->stock,
                'price'=>request()->precio,
                'tags'=>request()->tags,
                'image'=>$nombre,
                'slug'=>''
            ]);
            $producto->save();
            dd($producto->id);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}