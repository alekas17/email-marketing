<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = apiValidate($request->all(), [
            'password_old' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator) {
            return $validator;
        }

        $user = auth()->user();

        $password_old = $request->password_old;

        if (!Hash::check($password_old, $user->password)) {
            return response()->json([
                'errors' => ['password_old' => ['Old password doesnt match!']]
            ], 422);
        }

        $password_new = Hash::make($request->password);

        $user->password = $password_new;
        $user->save();

        return response()->json([
            'message' => 'Your password has been changed.'
        ]);
    }
}
