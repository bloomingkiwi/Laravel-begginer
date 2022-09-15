<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Validator;
use Auth;

class BooksController extends Controller
{
    //更新
    public function update(Request $request) {
        // バリデーション
    $validator = Validator::make($request->all(),[
        'id' => 'required',
        'item_name' => 'required|max:255|min:3',
        'item_number' => 'required|max:3|min:1',
        'item_amount' => 'required|max:6',
        'published' => 'required',

    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // データ更新
    $books = Book::find($request->id);
    $books->item_name = $request->item_name;
    $books->item_number = $request->item_number;
    $books->item_amount = $request->item_amount;
    $books->published = $request->published;
    $books->save();
    return redirect('/');
    }

    // 登録
    public function store(Request $request) {
        //バリデーション
    $validator = Validator::make($request->all(), [
        'item_name' => 'required|max:255|min:3',
        'item_number' => 'required|max:3|min:1',
        'item_amount' => 'required|max:6',
        'published' => 'required',
    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // Eloquintモデル
    $books = new Book;
    $books->item_name = $request->item_name;
    $books->item_number = $request->item_number;
    $books->item_amount = $request->item_amount;
    $books->published = $request->published;
    $books->save();
    return redirect('/')->with('message','本登録が完了しました');
    }

    //本ダッシュボード表示
    public function index() {
        $books = Book::orderBy('created_at', 'asc')->paginate(3);
        return view('books', [
        'books' => $books
    ]);
    }

    // 更新画面
    public function edit(Book $books) {
        // {books}id値を取得 => Book $books id値の1レコード取得
        return view('booksedit',['book' => $books]);
    }

    //削除処理
    public function delete(Book $books) {
        $book->delete();
        return redirect('/');
    }
};
