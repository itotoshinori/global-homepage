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
    public function update(Request $request, User $user)
    {
        $update=[
            'name' => $request->name,
            'email' => $request->email,
        ];
        $result=$user->update($update);
        if ($result) {
            $status= "success";
            $message = "ユーザー情報を更新しました。";
        } else {
            $status= "success";
            $message = "ユーザー情報に失敗しました。";
        }
        return redirect()->route('infos.index')
                        ->with($status, $message);
    }
    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('users.index')
                        ->with('success', "削除しました。");
    }
}
