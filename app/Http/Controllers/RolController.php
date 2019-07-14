<?php

namespace App\Http\Controllers;

use App\Rol;
use Laravel\Lumen\Http\Request;

class RolController extends Controller
{
    public function findAll()
    {
        return Rol::with('user')->get();
    }

    public function create(Request $request)
    {
        $data = $request->json()->all();
        return Rol::create(['name' => $data['name']]);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $result = Rol::where(['id' => $data['id']])->update(['name' => $data['name']]);
        return ['INFO' => "Was Update $result Rows"];
    }

    public function delete(Request $request)
    {
        $data = $request->json()->all();
        $result = Rol::where(['id' => $data['id']])->delete();
        return ['INFO' => "Was Delete $result Rows"];
    }

    public function findById($id)
    {
        $rol = Rol::find($id);
        if ($rol)
            return $rol;
        else
            return ["Info" => "ROL NOT FOUND"];
    }
}
