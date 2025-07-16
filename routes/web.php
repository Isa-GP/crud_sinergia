<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;



Route::view('/', 'auth')->name('login');
Route::post('/set-token', function (\Illuminate\Http\Request $request) {
    session(['jwt_token' => $request->token]);
    return response()->json(['message' => 'Token guardado']);
});
Route::get('/pacientes', function () {
    if (!session('jwt_token')) {
        return redirect('/'); // si no hay token, lo devuelve al login
    }
    return view('pacientes');
})->name('pacientes');

