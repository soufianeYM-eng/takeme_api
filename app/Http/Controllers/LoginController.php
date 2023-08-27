<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        // Validate the phone number
        $request->validate([
            'telegram_id' => 'required',
        ]);

        // Find or create a user model
        $user = User::firstOrCreate([
            'telegram_id' => $request->telegram_id
        ]);

        if (!$user) {
            return response()->json(['message' => 'Could not process a user with that telegram username.'], 401);
        }

        // send the user a one-time use code
        $user->notify(new LoginNeedsVerification());

        // send backend response
        return response()->json(['message' => 'Text message notification send.']);
    }

    public function verify(Request $request): JsonResponse
    {
        // Validate the phone number
        $request->validate([
            'telegram_id' => 'required',
            'login_code' => 'required|numeric|between:111111,999999'
        ]);

        // Find the user
        $user = User::where('telegram_id', $request->telegram_id)->where('login_code', $request->login_code)->first();

        if ($user) {
            $user->update([
                'login_code' => null
            ]);
            return response()->json(['token' => $user->createToken('authlogin')->plainTextToken]);
        }

        return response()->json(['message' => 'Invalid verification code.'], 401);
    }
}
