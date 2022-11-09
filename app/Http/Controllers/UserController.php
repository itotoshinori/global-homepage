<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::oldest()->get();
        $user_emails= "";
        foreach ($users as $user) {
            $user_emails .= $user->email.";";
        }
        return view('users.index', [
            'users' => $users,
            'user_emails' =>$user_emails
        ]);
    }
    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('users.index')
                        ->with('success', "削除しました。");
    }
}
