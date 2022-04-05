<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function users()
    {
        $users = User::get();
        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',


            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }


        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        return response()->json([
            'status' => true,
            'data' => "Successfully added!!!"
        ], 201);
    }

    public function user($id)
    {
        $data = [];
        $user = User::where(['id' => $id])->select('id', 'name', 'email')->first();
        //если нет пользователя
        if (empty($user)) {
            return response()->json([
                'status' => false,
            ], 404);
        }

        $categories = Gift::where('user_id', '=', $id)
            ->where('parent_id', '=', 0)
            ->with('allChildrenAccounts')
            ->select('id', 'name')
            ->orderBy('id', 'ASC')
            ->get();
        $user['gifts'] = $categories;

        return response()->json([
            'status' => true,
            'data' => $user
        ], 200);
    }
}
