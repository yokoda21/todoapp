<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest; // TodoRequestを使用する場合
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category; // Categoryモデルを使用する場合
// TodoControllerは、TodoのCRUD操作を管理するコントローラーです。
// このコントローラーは、Todoの一覧表示、追加、編集、更新、削除を行います。


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
    }
    
    //ローカルスコープを使用し検索処理
    public function search(Request $request)
    {
        //dd('searchに到達', $request->all());
        $todos = Todo::with('category')
            ->categorySearch($request->category_id)
            ->keywordSearch($request->keyword)
            ->get();


        $categories = Category::all();
        return view('index', compact('todos', 'categories')); // ビューにデータを渡す
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
        $todo = $request->only([
            'category_id',
            'content'
        ]); // カテゴリIDとコンテンツをリクエストから取得
        Todo::create($todo);

        // リダイレクトやビュー返却
        return redirect()->route('todos.index')->with('success', 'TODOを追加しました！');
    }  

    // 更新
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ], [
            'content.required' => '文字、または数字を入力してください。',
            'content.max' => 'Todoは255文字以内で入力してください。',
        ]);

        $todo = \App\Models\Todo::findOrFail($id);
        $todo->update([
            'content' => $request->input('content')
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


//'todo' => $request->input('content'), // 6月5日(木)DBのコンテンツカラムに反映されないので変更
    //'category_id' => $request->category_id, // カテゴリIDをリクエストから取得
    //'category_id' => 1, // 仮のカテゴリIDを設定,5月26日(月)追加

    // 編集、編集画面への遷移、インライン編集では使用しない
    /* public function edit($id)
    {
        $todo = \App\Models\Todo::findOrFail($id);
        $todos = \App\Models\Todo::all();
        return view('index', compact('todo', 'todos')); // 編集用データも渡す
        return redirect()->route('todos.index')->with('success', 'TODOを編集しました！');
    //} */
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
    /*$keyword = $request->input('keyword');
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $query = Todo::query();
            $query->where('todo', 'LIKE', "%{$keyword}%");
            $todos = $query->get();
            
            return view('index', compact('todos', 'keyword'));
        }

        //return view('index', compact('todos', 'editid', 'editTodo')); // ビューにデータを渡す
        //return redirect()->route('todos.index')->with('success', 'TODOを新規作成しました！'); 
    }*/
