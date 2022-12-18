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
        if ($request->authority <= 3) {
            $update['registration'] = true;
        } else {
            $update['registration'] = false;
            //退職者のメールアドレスはランダムにする
            $this->class_func = new My_func();
            $update['email'] = $this->class_func->retire_mail()."@global-software.co.jp";
            $message = "退職者のメールアドレスはログインできぬようランダム文字に設定しました。";
        }
        $result = $user->update($update);
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
    public function pw_change(Request $request, int $id)
    {
        $new_password = $request->new_password;
        $new_password_confirm = $request->new_password_confirm;
        if (strlen($new_password) >= 8 && $new_password == $new_password_confirm) {
            $user = User::find($id);
            $user->password = bcrypt($new_password);
            $user->save();
            return redirect()->route('infos.index')
                                ->with('success', "パスワードの変更に成功しました。");
        } else {
            return redirect()->route('infos.index')
                                ->with('danger', "文字数の不足か変更パスワードと変更パスワード確認の不一致で変更に失敗しました。再度実施して下さい。");
        }
    }
}
