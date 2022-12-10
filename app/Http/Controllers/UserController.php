<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use App\lib\My_func;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('email', 'desc')->where('registration', true);
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
        if (!$request->name) {
            $user->note = $request->note;
            $user->save();
            return redirect()->route('infos.index')->with('success', "更新しました");
        }
        $update=[
            'name' => $request->name,
            'email' => $request->email,
            'authority' => $request->authority,
            'note' => $request->note,
            'registration' => $request->registration
        ];
        $message = "";
        if ($request->registration == "on") {
            $update['registration'] = true;
        } else {
            $update['registration'] = false;
            //退職者のメールアドレスはランダムにする
            $this->class_func = new My_func();
            $update['email'] = $this->class_func->retire_mail()."@global-software.co.jp";
            $message = "退職者のメールアドレスはログインできぬようランダム文字に設定しました。";
        }
        $result=$user->update($update);
        if ($result) {
            $status= "success";
            $message = "ユーザー情報を更新しました。".$message;
        } else {
            $status= "danger";
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
