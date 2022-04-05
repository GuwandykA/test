<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;


class GiftController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'user_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }


        $user = new Gift;
        $user->name = $request->name;
        $user->user_id = $request->user_id;
        $user->parent_id = $request->parent_id;
        $user->save();

        return response()->json([
            'status' => true,
            'data' => "Successfully added!!!"
        ], 201);
    }


    public function destroy($id)
    {
        $gift = Gift::where('id', $id)->first();
        //если нет подарок
        if (empty($gift)) {
            return [
                'status' => false,
                'error' => "Woops error!!!"

            ];
        }
        $child_gift_id = Gift::where('child_gift_id', $id)->get();

        if ($child_gift_id) {
            foreach ($child_gift_id as $cl) {
                $cl->forceDelete();
            }
        }

        $gift->forceDelete();

        return response()->json([
            'status' => true,
            'data' => "Successfully deleted!!!"
        ], 200);
    }
}
