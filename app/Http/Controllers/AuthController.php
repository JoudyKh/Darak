<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\CheckVerificationCodeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendVerificationCodeRequest;

use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Requests\Auth\UpdateChatSettingsRequest;
use App\Http\Requests\Auth\UpdateGeneralSettingsRequest;
use App\Http\Requests\Auth\UpdateNotificationSettingsRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserDataValidationRequest;
use App\Http\Resources\UserRecourse;
use App\Models\PasswordResetCode;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class AuthController extends Controller
{

    public function profile()
    {
        return success(
            request()->user(),
            200
        );
    }


    public function authCheck(): JsonResponse
    {
        return success();
    }


    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->whereHas('role', function ($q) {
                $q->where('name', Constants::ROLES['admin']);
            })
            ->first();
        if (!$user)
            return error([__('messages.email_is_not_correct')], __('messages.email_is_not_correct'), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        if (!Hash::check($request->password, $user->password))
            return error([__('messages.wrong_password')], __('messages.wrong_password'), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        $token = $user->createToken('auth')->plainTextToken;

        return success(
            [
                'user' => $user,
                'token' => $token
            ]
        );
    }

    function logout()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return success(['message' => __('messages.successfully_logged_out')]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update(
                ['password' => Hash::make($request->password)]
            );
            return success(__('messages.password_updated_successfully'));
        }
        return error([__('messages.wrong_old_password')], __('messages.wrong_old_password'), 422);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $passwordResetCode = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->verification_code)
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))->first();
        if (!$passwordResetCode) {
            return error(
                [
                    __('messages.invalid_verification_code')
                ],
                __('messages.invalid_verification_code'),
                422
            );
        }
        $passwordResetCode->delete();
        $user = User::where('email', $request->email)->first();
        $user->update(
            ['password' => Hash::make($request->password)]
        );
        return success(__('messages.password_updated_successfully'));
    }


    public function checkVerificationCode(CheckVerificationCodeRequest $request): JsonResponse
    {
        $passwordResetCodeStatus = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->verification_code)
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))->exists();
        return success([
            'code' => $request->verification_code,
            'is_valid' => $passwordResetCodeStatus,
        ]);
    }


    public function sendVerificationCode(SendVerificationCodeRequest $request): JsonResponse
    {
        $admin = User::where('email', $request->email)->first();
        $code = rand(1000, 9999);
        $details = [
            'title' => __('messages.your_verification_code_is'),
            'body' => $code,
        ];
        Mail::to($request->email)->send(new \App\Mail\VerificationCode($details));
        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expired_at' => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s')
        ]);
        return success(__('messages.verification_code_sent_successfully'));
    }
}
