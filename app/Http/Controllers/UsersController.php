<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{
    function index(Request $request)
    {
        //Comprobamos que la petición sea de tipo application/json
        if ($request->isJson()) {
            //Usando estructura de eloquent para generar consultas a la base de datos
            //LIST USER
            $user = User::with('rol')->get();
            return response()->json($user, 200);
        } else {
            //Mensaje de error si la petición no es de tipo application/json
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    function createUser(Request $request)
    {
        //TODO: Crete user in DB
        if ($request->isJson()) {
            //Obtenemos los datos en formato Json
            $data = $request->json()->all();
            //Realizamos el create del usuario mandando un arreglo asociativo
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'token' => str_random(60),
                'rol_id' => $data['rol_id']
            ]);
            return response()->json([$user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    function updateUser(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();
            $user = User::where('id', $data['id'])->update([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'rol_id' => $data['rol_id']
            ]);
            return response()->json([$user], 200);
        } else {
            return response()->json(['error' => 'Petition Unauthorized'], 401, []);
        }
    }
    function getUser(Request $request, $id)
    {
        if ($request->isJson()) {
            $user = User::find($id);

            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    function deleteUser(Request $request)
    {

        $data = $request->json()->all();
        if ($request->isJson()) {
            $user = User::find($data['id']);
            $user->delete();
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    //Metodo para realizar login
    function getToken(Request $request)
    {
        if ($request->isJson()) {
            try {
                $data = $request->json()->all();
                $user = User::where('username', $data['username'])->first();
                if ($user && Hash::check($data['password'], $user->password)) {
                    return response()->json($user, 200);
                } else {
                    return response()->json(['error' => 'Datos erroneos'], 406, []);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Usuario No Registrado'], 406, []);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
