<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//以下を追記することでNews Modelが扱えるようになる。１５課で追記
use App\News;
//#18
use App\History;
//Carbonを利用して取得した現在時刻を、Historyモデルのedited_atとして記録する
use Carbon\Carbon;

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
        //validationを行う
        $this->validate($request, News::$rules);

        $news = new News;
        $form = $request->all();

        //フォームから画像が送信されて来たら、保存して、$news->image_pathに画像のパスを保存する
        if (isset($form['image'])) {
          $path = $request->file('image')->store('public/image');
          $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }

        //フォームから送信されて来た_takenを削除する
        unset($form['_token']);
        //フォームから送信されて来たimageを削除する
        unset($form['image']);

        //データベースに保存する
        $news->fill($form);
        $news->save();

        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }

    //以下１６課で追記
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            //検索されたら検索結果を取得する
            $posts = News::where('title', $cond_title)->get();
        } else {
            //それ以外は全てのニュースを取得する
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }

    //以下１７課で追記
    public function edit(Request $request)
    {
        //News Modelからデータを取得する
        $news = News::find($request->id);

        return view('admin.news.edit', ['news_form' => $news]);
    }

    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request, News::$rules);
        // News Modelからデータを取得する
        $news = News::find($request->id);
        //送信されてきたフォームデータを格納する #18
        $news_form = $request->all();
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);
        //該当するデータを上書きして保存する
        $news->fill($news_form)->save();

        #18
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news');
    }
    //データを削除する
    public function delete(Request $request)
    {
        //該当するNews Modelを取得
        $news = News::find($request->id);
        //削除する
        $news->delete();
        return redirect('admin/news/');
    }
}
