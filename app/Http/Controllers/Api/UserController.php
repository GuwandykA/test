<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    public function users()
    {
        $users = User::get();
        return $this->successResponse($users, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }
        $data = $request->all();
        $ceo = User::create($data);


        // $user = new User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->save();

        return $this->successResponse('User Created', null,201);
    }

    public function user($id)
    {
        $user = User::where(['id' => $id])->select('id', 'name', 'email')->first();
        //если нет пользователя
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $categories = Gift::where('user_id', '=', $id)
            ->where('parent_id', '=', 0)
            ->with('allChildrenGift')
            ->select('id', 'name')
            ->orderBy('id', 'ASC')
            ->get();
        $user['gifts'] = $categories;

        return $this->successResponse($user, 200);
    }

    public function data(Request $request)
    {
        if ($request->has('name')) {
            $name = $request->input('name');
             return $this->successResponse("data", $name,200);
     }
        return $this->successResponse("data isn't id", null,200);
    }


    public function validateUser()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }
}
