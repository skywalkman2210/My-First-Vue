<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;
use Illuminate\Http\Request;

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

Route::get('/cars', function() {
    $resp = array(
        'cars' => DB::table('cars')->where('deleted', '=', 0)->get()
    );

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resp);
});

Route::get('/cars/{id}', function($id) {
    $resp = array(
        'car' => App\Models\Car::find($id)
    );

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resp);
});

Route::post('/cars', function(Request $request) {
    $car;

    if ($request->id === 0) {
        $car = new App\Models\Car();

        $car->make = $request->make;
        $car->model = $request->model;
        $car->year = (int)$request->year;
        $car->vin = $request->vin;
        $car->plate = $request->plate;
        $car->color = $request->color;
        $car->deleted = false;

        $car->save();
    } else {
        $car = App\Models\Car::find($request->id);

        $car->make = $request->make;
        $car->model = $request->model;
        $car->year = (int)$request->year;
        $car->vin = $request->vin;
        $car->plate = $request->plate;
        $car->color = $request->color;
        $car->deleted = false;

        $car->save();
    }
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($car);
});

Route::post('/cars/delete', function(Request $request) {
    if ($request->id !== 0) {
        $car = App\Models\Car::find($request->id);

        $car->deleted = true;
        $car->save();
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($car);
    }
});