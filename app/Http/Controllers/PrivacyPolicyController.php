<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privacy_policy = PrivacyPolicy::first();
        return view('privacypolicy.index', [
            'privacy_policy' => $privacy_policy,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 2. データが見つからない場合は自動で404エラーにするfindOrFailを使うと安全
        $privacy_policy = PrivacyPolicy::findOrFail($id);

        return view('privacypolicy.edit', [
            'privacy_policy' => $privacy_policy,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:30',
            'content' => 'required',
        ]);
        try {
            $privacy_policy = PrivacyPolicy::findOrFail($id);
            $privacy_policy->update($validated);

            // 成功した場合：indexに戻り、成功メッセージを表示
            return redirect()->route('privacypolicy.index')
                ->with('success', 'プライバシーポリシーを更新しました。');
        } catch (\Exception $e) {
            // 失敗した場合：入力値を保持したまま（withInput）、前のページ（編集画面）に戻りエラーメッセージを表示
            return back()->withInput()
                ->with('error', '更新に失敗しました。もう一度やり直してください。');
        }
    }
}
