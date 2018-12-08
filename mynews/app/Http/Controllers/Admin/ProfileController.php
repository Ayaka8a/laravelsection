<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//15課課題で必要な気がする・・・
use App\profile;

class ProfileController extends Controller
{
    //以下Action追記
    public function edit()
    {
      return view('admin.profile.edit');
    }
    public function update()
    {
      return redirect('admin/profile/edit');
    }
    public function create(Request $request)
    {
        //15課課題
        //validationを行う
        $this->validate($request, Profile::rules);

        $profile = profile Profile;
        $form = $request->all();

        //formから送信されてきた_tokenを削除する
        unset($form['_token']);

        //データベースへ保存する
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/edit');
    }
}
