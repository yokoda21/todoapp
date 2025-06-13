<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $editid = $request->input('editid'); // 編集IDを取得
        $categories = \App\Models\Category::all(); // カテゴリを取得        
        $editTodo = null;

        if ($editid) {
            $editTodo = todo::find($editid); // 編集用データを取得         
        }

        return view('category.index', compact('categories', 'editTodo')); // ビューにデータを渡す
    }


    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return redirect()->route('categories.index')->with('success', 'カテゴリーが作成されました。'); //カテゴリー作成
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // IDに基づいてカテゴリを取得
        return view('category.edit', compact('category')); // ビューにデータを渡す
    }
    public function update(CategoryRequest $request, $id)
    {
        $category = $request->only(['name']);
        Category::find($request->id)->update($category);

        return redirect()->route('categories.index')->with('success', 'カテゴリーを更新しました。'); // カテゴリ更新
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id'); // リクエストからIDを取得
        $category = Category::findOrFail($id); // IDに基づいてカテゴリを取得
        $category->delete(); // カテゴリを削除        
        return redirect()->route('categories.index')->with('success', 'カテゴリーが削除されました。'); // カテゴリ削除
    }
}
