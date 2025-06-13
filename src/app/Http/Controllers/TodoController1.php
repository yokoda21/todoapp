<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(Request $request)
    {
       
        // Todoモデルを使用してデータを取得
        $todos = \App\Models\Todo::all(); // すべてのTodoを取得
        $editid = $request->input('editid'); // 編集IDを取得
        $categories = \App\Models\Category::all(); // カテゴリを取得        
        $editTodo = null;
        if ($editid) {
            $editTodo = Todo::find($editid); // 編集用データを取得         
  
        }
        return view('index', compact('todos', 'categories', 'editTodo')); // ビューにデータを渡す
        
    /*public function show()
    {
        $options = [
        'option1' => '選択肢1',
        'option2' => '選択肢2',
        'option3' => '選択肢3'
    ];
        return view('form', compact('options'));
}
// 5月26日(月)追加


        /* キーワードから検索処理 */
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $query = Todo::query();
            $query->where('todo', 'LIKE', "%{$keyword}%");
            $todos = $query->get();
            
            return view('index', compact('todos', 'keyword'));
        }

        return view('index', compact('todos', 'editid', 'editTodo')); // ビューにデータを渡す
        return redirect()->route('todos.index')->with('success', 'TODOを新規作成しました！'); 
    }



    public function store(Request $request)
    {
        
        // バリデーション
        $request->validate([
            'content' => 'required|string|max:255',
        ], [
            'content.required' => '文字、または数字を入力してください。',
            'content.max' => 'Todoは255文字以内で入力してください。',
        ]);
        
        // データ保存
        \App\Models\Todo::create([
            'todo' => $request->input('todo'),
            'category_id' => $request->category_id, // カテゴリIDをリクエストから取得
            //'category_id' => 1, // 仮のカテゴリIDを設定,5月26日(月)追加
        ]);
        
        // リダイレクトやビュー返却
        return redirect()->route('todos.index')->with('success', 'TODOを追加しました！');
    }
    // 編集、編集画面への遷移、インライン編集では使用しない
   /* public function edit($id)
    {
        $todo = \App\Models\Todo::findOrFail($id);
        $todos = \App\Models\Todo::all();
        return view('index', compact('todo', 'todos')); // 編集用データも渡す
        return redirect()->route('todos.index')->with('success', 'TODOを編集しました！');
    //} */
    

    // 更新
    public function update(Request $request, $id)
    {
        $request->validate([
            'todo' => 'required|string|max:255',
        ], [
            'todo.required' => '文字、または数字を入力してください。',
            'todo.max' => 'Todoは255文字以内で入力してください。',            
        ]);

        $todo = \App\Models\Todo::findOrFail($id);
        $todo->update([
            'todo' => $request->input('todo')
        ]);
        //return redirect()->route('todos.index');
        return redirect()->route('todos.index')->with('success', 'TODOを編集しました！');
    }

    // 削除
    public function destroy($id)
    {
        $todo = \App\Models\Todo::findOrFail($id);
        $todo->delete();
        //return redirect()->route('todos.index');
        return redirect()->route('todos.index')->with('success', 'TODOを削除しました！');
    }
}
