<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    //以下を追記(addというActionを追加)
    public function add()
    {
        return view( 'admin.news.create');
    }
    //14課で追記
    public function create(Request $request)
    {
        // admin/news/vreateにリダイレクトする
        return redirect('admin/news/create');
    }
}
