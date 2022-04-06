<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;


class GiftController extends ApiController
{

    public function store(Request $request)
    {
        $validator = $this->validateGift();

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }


        $gift = new Gift;
        $gift->name = $request->name;
        $gift->user_id = $request->user_id;
        $gift->parent_id = $request->parent_id;
        $gift->save();

        return $this->successResponse('Gift Created', 201);
    }


    public function destroy($id)
    {
        $gift = Gift::where('id', $id)->first();
        //если нет подарок
        if (empty($gift)) {
            return $this->errorResponse("Not Found", 404);
        }
        $child_gift_id = Gift::where('parent_id', $id)->get();

        if ($child_gift_id) {
            foreach ($child_gift_id as $cl) {
                $cl->forceDelete();
            }
        }

        $gift->forceDelete();
        return $this->successResponse(null, 'Gift Deleted');
    }

    public function validateGift()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'user_id' => 'required|integer|min:1',
            'parent_id' => 'required|integer|min:1',
        ]);
    }
}
