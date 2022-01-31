<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/iot", function(){
    return view("remote"); 
    
    // return response()->json(["fan"=>10,"light"=>2]); 
}); 

Route::post("/iot", function(Request $request){
    // Stroring the value from the client input
    $fan = $request->fan;
    $light = $request->light;

    $config = [
        "fan"=>$fan, 
        "light"=>$light
    ];

    $path = base_path()."/resources/config/config.json"; 
    // Update json file 
    $file = fopen($path,"w+"); 
    file_put_contents($path, json_encode($config)); 
    $data = file_get_contents($path); 
    return $data; 
}); 

Route::get("/api", function(){
    $path = base_path()."/resources/config/config.json"; 
    $data = file_get_contents($path); 
    return $data; 
}); 
