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
    //crear un controlador con login con aws
    use RespuestaAPI;

    protected $reglas =
    [
        'email' => 'required|string|max:255',
        'password' => 'required|string|max:255',
    ];

    public function login(Request $request)
    {
        //Se valida la solicitud
        $validacion = Validator::make($request->all(), $this->reglas);
        //Si la validacion falla, se retorna un error
        if ($validacion->fails()) {
            return $this->error($validacion->errors(), 400);
        }
        //Se obtienen las credenciales
        $credenciales = request(['email', 'password']);
        //Se verifica si las credenciales son correctas
        if (!Auth::attempt($credenciales)) {
            return $this->error('Credenciales incorrectas', 401);
        }
        //Se obtiene el usuario
        $usuario = User::where('email', $request->email)->first();
        //Se crea el token
        $token = $usuario->createToken('auth_token')->plainTextToken;
        //Se retorna la respuesta
        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        //Se obtiene el usuario autenticado
        $usuario = $request->user();
        //Se revoca el token
        $usuario->tokens()->where('id', $usuario->currentAccessToken()->id)->delete();
        //Se retorna la respuesta
        return $this->success('Token revocado');
    }

    public function logoutAll(Request $request)
    {
        //Se obtiene el usuario autenticado
        $usuario = $request->user();
        //Se revocan todos los tokens
        $usuario->tokens()->delete();
        //Se retorna la respuesta
        return $this->success('Todos los tokens han sido revocados');
    }

    public function user(Request $request)
    {
        //Se retorna la respuesta
        return $this->success($request->user());
    }

    public function refresh(Request $request)
    {
        //Se obtiene el usuario autenticado
        $usuario = $request->user();
        //Se revoca el token
        $usuario->tokens()->where('id', $usuario->currentAccessToken()->id)->delete();
        //Se crea el token
        $token = $usuario->createToken('auth_token')->plainTextToken;
        //Se retorna la respuesta
        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function prueba()
    {
        return $this->success('Prueba exitosa');
    }

    
    

}
