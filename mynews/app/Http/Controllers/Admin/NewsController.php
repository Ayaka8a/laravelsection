<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//以下を追記することでNews Modelが扱えるようになる。１５課で追記
use App\News;

class NewsController extends Controller
{
    //以下を追記(addというActionを追加)
    public function add()
    {
        return view('admin.news.create');
    }
    //14課で追記
    public function create(Request $request)
    {
        //以下を追記
        //varidationを行う
        $this->validate($request, News::$rules);

        $news =new News;
        $form =$request->all();

        //フォームから画像が送信されて来たら、保存して、$news->image_pathに画像のパスを保存する
        if (isset($form['image'])) {
            $path =$request->file('image')->store('public/image');
            $news->image_path = null;
        } else {
            $news->image_path = null;
        }

        //formから送信されて来たら。保存して、$news->image_pathに画像のパスを保存する
        if (isset($form['image'])) {
          $path =$request->file('image')->store('public/image');
          $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }

        //フォームから送信されて来た_takenを削除する
        unset($form['_taken']);
        //フォームから送信されて来たimageを削除する
        unset($form['image']);

        //データベースに保存する
        $news->fill($form);
        $news->save();

        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }
}
