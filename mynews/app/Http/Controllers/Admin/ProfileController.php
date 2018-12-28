<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//15課課題で必要な気がする・・・
use App\profile;

class ProfileController extends Controller
{
    //以下Action追記
    public function edit(Request $request)
    {
        //Profile Modelからデータを取得する
        $profile = Profile::find($request->id);

        return view('admin.profile.edit', ['form' => $profile]);
    }

    public function update(Request $request)
    {
        //15課課題
        //validationを行う
        $this->validate($request, profile::$rules);
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        //送信されてきたフォームデータを格納する
        $form = $request->all();
        //formから送信されてきた_tokenを削除する
        unset($form['_token']);

        //データベースへ保存する
        $profile->fill($form)->save();

        return redirect('admin/profile/edit');
    }

}
