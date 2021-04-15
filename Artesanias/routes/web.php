<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});
Route::get('/admin', function () {
    return view('admin.index');
});
Route::get('/admin/usuarios', function () {
    return view('admin.users');
});
Route::get('/admin/productos', function () {
    return view('admin.productos');
});
Route::get('/practica', function () {
    return view('practica');
});
Route::get('/producto/{id}', function ($id) {
    return view('verproducto')->with('id',$id);
});
Route::get('/contacto', function(){
    $contacto='Erika Barrera';
    $valores=10;
    $color="#ccc";
    return view('contacto')->with('nombre',$contacto)
    ->with('fondo',$color)
    ->with('valores',$valores);
});
