<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use File;
class ProductosController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
       
        $datos=\DB:: table('products')
        -> select('products.*')
        -> orderBy('id','DESC')
        -> get();
         return view('admin.productos')
         -> with('productos', $datos);
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
            'image'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return back()
            ->withInput()
            ->with('errorInsert', 'Favor de llenar todos los campos')
            ->withErrors('Favor de llenar los campos');
        }else{
            $image=$request->file('image');
            $nombre=time().'.'.$image->getClientOriginalExtension();
            $destino=public_path('images/productos');
          
            $request->image->move($destino,$nombre);
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
            return back() ->with('Listo', 'se ha insertado correctamente');
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
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre'=>'required|max:255|min:1',
            'descripcion'=>'required|max:255|min:1',
            'stock'=>'required|min:1|numeric',
            'precio'=>'required|min:1|numeric',
            'tags'=>'required|max:255|min:1'
        ]);
        if($validator->fails()){
            return back()
            ->withInput()
            ->with('errorEdit', 'Favor de llenar todos los campos')
            ->withErrors($validator);
        }else{
            $producto=Product::find($request->id);
            $producto->name=$request->nombre;
            $producto->description=$request->descripcion;
            $producto->stock=$request->stock;
            $producto->price=$request->precio;
            $producto->tags=$request->tags;
            $validator2 = Validator::make($request->all(),[
                'image'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
            ]);

            if(!$validator2->fails()){
                $image=$request->file('image');
                $nombre=time().'.'.$image->getClientOriginalExtension();
                $destino = public_path('image/productos');
                $request->image->move($destino, $nombre);
                if(File::exists(public_path('image/productos/'.$producto->image))){
                    unlink(public_path('image/productos/'.$producto->image));
                }
                $producto->image=$nombre;
            }
            $producto->save();
            return back()->with('Listo', 'Se ha actualizado correctamente');
        }

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
         $producto =Product::find($id);
        if(File::exists(public_path('image/productos'.$producto->image))){
            unlink( public_path('image/productos'.$producto->image) );
        }
        $producto->delete();
        return back() ->with('Listo', 'se ha borrado correctamente'); //
    }
}