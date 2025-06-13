@extends('layouts.app')

@section('title', 'Todo一覧')

@section('header')
Todo
@endsection

@section('content')
    {{-- メッセージ表示 --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    @if (session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- 新規作成フォーム --}}
    <div class="section__title">
      <h2>新規作成</h2>
    </div>
    <form class="create-form" action="/todos" method="post">
      @csrf
      <div class="create-form__item">
        <input
          class="create-form__item-input"
          type="text"
          name="content"
        value="{{ old('content') }}"
        />
        <select class="create-form__item-select">
          <option value="">カテゴリ</option>
        </select>
      </div>
      <div class="create-form__button">
        <button class="create-form__button-submit" type="submit">作成</button>
      </div>
    </form>
    {{-- 新規作成フォームここまで --}}

    {{-- Todo検索フォーム --}}
    <div class="section__title">
      <h2>Todo検索</h2>
    </div>
  <form action="/todos" method="GET" class="todo-search-form">
    @csrf
    <input type="text" name="keyword" placeholder="キーワードを入力" value="{{ request('keyword') }}" class="todo-search-input">
    <button type="submit" class="todo-search-button">検索</button>
  </form>
  {{-- Todo検索フォームここまで --}}  
  <div class="todo-table">
    <table class="todo-table__inner">
      <tr class="todo-table__row">
       <th class="todo-table__header">Todo</th>
       <th class="todo-table__header">
         <span class="todo-table__header-span">Todo</span>
         <span class="todo-table__header-span">カテゴリ</span> 
       </th>
      </tr> 
      <div class="todo-table">
    <table class="todo-table__inner">
      <tr class="todo-table__row">
       <th class="todo-table__header">
         <span class="todo-table__header-span">Todo</span>
         <span class="todo-table__header-span">カテゴリ</span> 
       </th>         
    {{-- カテゴリ選択フォーム 5月26日(月)追加--}}
  <form action="/todos" method="POST" > {{--class="todo-form-flex">----}} 
    @csrf
    {{--<input type="text" name="todo" placeholder="カテゴリーを選択" value="{{ old('todo') }}" class="todo-input">--}}
    {{-- カテゴリ選択 --}}  
    <label for="category_id">カテゴリー:</label>
    {{-- カテゴリの選択肢を表示 --}}
    <select name="category_id" id="category_id" class="todo-select">
        <option value="">カテゴリーを選択</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
  </form>
        
    <select name="category_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>


    {{--<select name="number">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
    </select>
    <button type="submit">作成</button>
</form> 5月26日 追加--}}

{{-- 検索機能ここから,5月24日追加 --}}
{{--<div>
  <form action="{{ route('todos.index') }}" method="GET">
    @csrf
    <input type="text" name="keyword">
    <input type="submit" value="検索">
  </form>
</div>--}}
{{-- 検索機能ここまで 5/29コメントアウト--}}

    {{-- Todoリスト表示 --}}
  <table>
        <thead>
            <tr>
                <th>Todo</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($todos as $todo)
        <tr>
      <td>
        @if (isset($editid) && $editid == $todo->id)
          <form action="{{ route('todos.update', $todo->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <input type="text" name="todo" value="{{ old('todo', $todo->todo) }}" class="todo-input" style="width:120px;">
            <button type="submit" class="btn btn-update">保存</button>
            <a href="{{ route('todos.index') }}">キャンセル</a>
          </form>
        @else
          {{ $todo->todo }}
        @endif
        </td>
          <td>
          @if (!(isset($editid) && $editid == $todo->id))
            <form action="{{ route('todos.index') }}" method="GET" style="display:inline;">
              <input type="hidden" name="editid" value="{{ $todo->id }}">
              <button type="submit" class="btn btn-update">更新</button>
            </form>
          @endif
            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" onclick="return confirm('削除しますか？');">削除</button>
            </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
