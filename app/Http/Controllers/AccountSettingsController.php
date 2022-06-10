<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\AccountSettingsRequest;

class AccountSettingsController extends Controller
{
    /**
     * Display the account settings page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('AccountSettings');
    }

    /**
     * Update the account settings of the authenticated user.
     *
     * @param  \App\Http\Requests\AccountSettingsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountSettingsRequest $request)
    {
        auth()->user()->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Account Settings updated successfully.',
        ], 201);
    }

    /**
     * Change the password of the authenticated user.
     *
     * @param  \App\Http\Requests\AccountSettingsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        if (! Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invallid current password.',
            ]);
        }

        auth()->user()->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.',
        ], 201);
    }
}
