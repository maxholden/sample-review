<?php

namespace App\Services\Contacts;
use App\Models\User;

class AdminService {

    public function __construct() {
    }

    public function updateUser(User $user, $data) {
        if( auth()->user()->canEditUser($user) ) {
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->save();
        }
        return false;
    }

}
