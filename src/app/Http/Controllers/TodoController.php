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
        $editTodo = null;
        if ($editid) {
            $editTodo = Todo::find($editid); // 編集用データを取得
        }
        return view('index', compact('todos', 'editid', 'editTodo')); // ビューにデータを渡す
        return redirect()->route('todos.index')->with('success', 'TODOを新規作成しました！'); 
    }



    public function store(Request $request)
    {
        // バリデーション（例）
        $request->validate([
            'todo' => 'required|string|max:255',
        ], [
            'todo.required' => '文字、または数字を入力してください。',
            'todo.max' => 'Todoは255文字以内で入力してください。',
        ]);
    
        // データ保存
        \App\Models\Todo::create([
            'todo' => $request->input('todo'),
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
