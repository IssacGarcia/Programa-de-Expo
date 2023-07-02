<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\RespuestaAPI;
use App\Models\User;
use Illuminate\Support\Facades\Auth;




class LoginController extends Controller
{
    //crear un controlador con login con jwt

    use RespuestaAPI;

    public function login(Request $request)
    {
        $credenciales = $request->only('email', 'password');
        $token = Auth::attempt($credenciales);
        if (!$token) {
            return $this->error('Credenciales incorrectas', 401);
        }
        return $this->success(['token' => $token]);
    }

    public function logout()
    {
        Auth::logout();
        return $this->success('Sesion cerrada');
    }

    public function refresh()
    {
        $token = Auth::refresh();
        return $this->success(['token' => $token]);
    }

    public function me()
    {
        $user = Auth::user();
        return $this->success($user);
    }

    public function payload()
    {
        return Auth::payload();
    }

    public function register(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'name' => 'required|string|max:60',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:60',
        ]);

        if ($validacion->fails()) {
            return $this->error('Error de validacion', 422, $validacion->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = bcrypt($request->password);
        $user->save();

        return $this->success($user);
    }

    public function update(Request $request, $id)
    {
        $validacion = Validator::make($request->all(), [
            'name' => 'required|string|max:60',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:60',
        ]);

        if ($validacion->fails()) {
            return $this->error('Error de validacion', 422, $validacion->errors());
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = bcrypt($request->password);
        $user->save();

        return $this->success($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $this->success($user);
    }
    
    

}
