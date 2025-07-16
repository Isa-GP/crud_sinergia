<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;


class userController extends Controller
{
    

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return response()->json(compact('token'));
    }

     //  Listar todos los pacientes
    public function index()
    {
        return response()->json(Paciente::all());
    }
//  Crear nuevo paciente
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento' => 'required|string|max:100|unique:pacientes,numero_documento',
            'nombre1' => 'required|string',
            'nombre2' => 'nullable|string',
            'apellido1' => 'required|string',
            'apellido2' => 'nullable|string',
            'genero_id' => 'required|exists:genero,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'nullable|email',
        ]);

        $paciente = Paciente::create($validated);
        return response()->json($paciente, 201);

    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);

    } catch (Exception $e) {
        return response()->json(['error' => 'Error al crear el paciente.'], 500);
    }
}
// Mostrar un solo paciente por ID
public function show($id)
{
    $paciente = \App\Models\Paciente::find($id);

    if (!$paciente) {
        return response()->json(['message' => 'Paciente no encontrado'], 404);
    }

    return response()->json($paciente);
}


    //  Actualizar un paciente
    
public function update(Request $request, $id)
{
    try {
        $paciente = Paciente::findOrFail($id);

        $validated = $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento'  => 'required|string|max:100|unique:pacientes,numero_documento,' . $id,
            'nombre1'           => 'required|string',
            'nombre2'           => 'nullable|string',
            'apellido1'         => 'required|string',
            'apellido2'         => 'nullable|string',
            'genero_id'         => 'required|exists:genero,id',
            'departamento_id'   => 'required|exists:departamentos,id',
            'municipio_id'      => 'required|exists:municipios,id',
            'correo'            => 'nullable|email',
        ]);

        $paciente->update($validated);
        return response()->json($paciente);

    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Paciente no encontrado.'], 404);

    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);

    } catch (Exception $e) {
        return response()->json(['error' => 'Error al actualizar el paciente.'], 500);
    }
}


   //  Eliminar un paciente
    public function destroy($id)
    {
    try {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);

    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Paciente no encontrado.'], 404);

    } catch (Exception $e) {
        return response()->json(['error' => 'Error al eliminar el paciente.'], 500);
    }
}

}





