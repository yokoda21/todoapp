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
<div class="todo-table-wrapper">
  <form action="{{ route('todos.store') }}" method="POST" class="todo-form-flex">
    @csrf
    <input type="text" name="todo" value="{{ old('todo') }}" class="todo-input">
    <button type="submit" class="btn btn-create">作成</button>
  </form>
</div>

   {{-- <form action="{{ route('todos.store') }}" method="POST" style="margin-bottom: 20px;">
    @csrf
    <input type="text" name="todo" value="{{ old('todo') }}" class="todo-input">
    <button type="submit" class="btn btn-create">作成</button>
</form> --}}

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
