<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Yodlee\Yodlee;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            'message' => 'User Profile',
            'user' => [
                "name" => $user->name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "phone" => $user->phone,
                "verified" => $user->verified,
                "user_type" => $user->user_type,
                "birthday" => $user->birthday,
                "postal" => $user->postal,
                "age_bracket" => $user->age_bracket,
                "gender" => $user->gender,
                "referral_link" => route('register') . '?ref=' . $user->id,
                "has_passcode" => ($user->passcode) ? true : false,
                "avatar_uri" => $user->avatar_uri
            ]
        ]);
    }

    public function updateProfile(Request $request, $id = "")
    {
        #validator
        $validator = apiValidate($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric'
        ]);

        if ($validator) {
            return $validator;
        }
        #end validator

        $user = auth()->user();

        if ($user->user_type == 1) {
            if ($id) {
                $user = User::find($id);
            }

            if (!$user) {
                return response()->json([
                    'message' => 'This user was not found ot invalid.'
                ], 404);
            }
        }

        $columns_to_update = [
            "name",
            "last_name",
            "phone",
            "email",
            "birthday",
            "postal",
            "age_bracket",
            "gender"
        ];

        foreach ($columns_to_update as $column) {
            if ($request->{$column}) {
                $user->{$column} = $request->{$column};
            }
        }

        Yodlee::updateUser(
            [
                "email" => $user->email,
                "name" => [
                    "first" => $user->name,
                    "last" => $user->last_name
                ]
            ],
            $user->id
        );

        $user->update();

        return response()->json([
            'message' => $user->name  . ' profile has been updated.',
            'user' => [
                "name" => $user->name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "phone" => $user->phone,
                "verified" => $user->verified,
                "user_type" => $user->user_type,
                "birthday" => $user->birthday,
                "postal" => $user->postal,
                "age_bracket" => $user->age_bracket,
                "gender" => $user->gender,
                "referral_link" => route('register') . '?ref=' . $user->id,
            ]
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $user = auth()->user();

        $user->avatar_uri = $request->avatar_uri;
        $user->save();

        return response()->json([
            'message' => 'Avatar image has been updated.',
            'user' => [
                "avatar_uri" => $user->avatar_uri
            ]
        ]);
    }

    public function deleteUser($id)
    {
        $auth_user = auth()->user();

        if ($auth_user->user_type != 1) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        $user = User::find($id);

        Yodlee::unregisterUser($user->id);

        $user->delete();

        return response()->json([
            'message' => '<strong>' . $user->email . '</strong> has been deleted.',
            'user' => $user
        ]);
    }
}
