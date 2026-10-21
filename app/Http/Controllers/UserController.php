<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * @api {post} /login Bejelentkezés
     * @apiName Login
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription Sikeres belépés után a felhasználó korábbi tokenjei törlődnek, és új Sanctum token készül. Ezt a tokent kell a védett végpontoknál az `Authorization: Bearer <token>` fejlécben küldeni.
     *
     * @apiBody {String} email E-mail cím
     * @apiBody {String} password Jelszó
     *
     * @apiSuccess {Object} user A bejelentkezett felhasználó
     * @apiSuccess {Number} user.id Felhasználó azonosítója
     * @apiSuccess {String} user.email E-mail cím
     * @apiSuccess {String} user.token Bearer token a további kérésekhez
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "user": {
     *         "id": 1,
     *         "email": "peter@example.com",
     *         "token": "1|abcdef123456..."
     *       }
     *     }
     *
     * @apiError (401) InvalidCredentials Hibás e-mail cím vagy jelszó
     * @apiError (422) ValidationError Hiányzó vagy érvénytelen mező
     *
     * @apiErrorExample {json} 401 Hibás belépési adatok:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "message": "Invalid email or password"
     *     }
     *
     * @apiErrorExample {json} 422 Hiányzó mező:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "The email field is required.",
     *       "errors": {
     *         "email": ["The email field is required."]
     *       }
     *     }
     */
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $password ? $user->password : '')){
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user->tokens()->delete();

        $user->token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
        ]);

    }

    /**
     * @api {get} /users Felhasználók listázása
     * @apiName GetUsers
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription Jelenleg nyilvános végpont, bejelentkezés nélkül is hívható.
     *
     * @apiSuccess {Object[]} users Felhasználók listája
     * @apiSuccess {Number} users.id Felhasználó azonosítója
     * @apiSuccess {String} users.email E-mail cím
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "users": [
     *         { "id": 1, "email": "peter@example.com" }
     *       ]
     *     }
     */
    public function index(Request $request){
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }
}
