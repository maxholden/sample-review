<?php

namespace App\Http\Controllers;

use App\Services\Contacts\AdminService;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function usersList(Request $request){
        Validate::validate($request, [
            'page' => 'required|integer',
            'per_page' => 'required|integer',
        ]);

        $currentUser = $request->user();

        if($currentUser->role !== 'admin'){
            return response()->json([
                'message' => 'Access denied'
            ], 403);
        }

        $users = User::where('role', 'user')
            ->where('status', 'active')
            ->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json([
            'users' => $users->map(function($user){
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'created_at' => $user->created_at,
                ];
            }),
        ]);
    }

    public function updateUser(User $user, UpdateUserRequest $request){
        $adminService = new AdminService();
        $adminService->updateUser($user, $request->all());

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

}

