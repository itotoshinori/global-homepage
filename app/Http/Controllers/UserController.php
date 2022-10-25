<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::oldest()->get();
        return view('users.index', [
            'users' => $users,
        ]);
    }
    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('users.index')
                        ->with('success', "削除しました。");
    }
}
