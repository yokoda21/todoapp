@extends('layouts.app')
@section('title', 'Todo一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="todo-main-center">

  {{-- メッセージ表示 --}}
  @if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if (session('message'))
  <div class="alert-success">{{ session('message') }}</div>
  @endif
  @if ($errors->any())
  <div class="alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  {{-- タイトル&カテゴリーページリンク --
  <div class="todo-header-bar">
    <span class="todo-header-title">Todo</span>
    <a href="/categories" class="todo-category-link">カテゴリ一覧</a>
  </div>--}}

  <div class="section__title">
    <h2>新規作成</h2>
  </div>

  {{-- 新規作成フォーム --}}
  <form class="todo-form-flex" action="/todos" method="post">
    @csrf
    <input class="todo-input" type="text" name="content" value="{{ old('content') }}" placeholder="Todoを入力">
    <select name="category_id" class="todo-select">
      <option value="">カテゴリーを選択</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
    <button class="todo-btn-black" type="submit">作成</button>
  </form>

  <div class="section__title">
    <h2>Todo検索</h2>
    {{-- 検索フォーム --}}
    <form class="todo-form-flex" action="/todos/search" method="get">
      <input class="todo-input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="キーワード">
      <select name="category_id" class="todo-select">
        <option value="">カテゴリーを選択</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
        @endforeach
      </select>
      <button class="todo-btn-black" type="submit">検索</button>
    </form>

    {{-- Todo一覧テーブル --}}
    <div class="todo-table-wrap">
      <table class="todo-table">
        <thead>
          <tr>
            <th>Todo</th>
            <th>カテゴリ</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($todos as $todo)
          <tr>
            <td>
              <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="todo-inline-form">
                @csrf
                @method('PUT')
                <input type="text" name="content" value="{{ $todo->content }}" class="todo-inline-input">
            </td>
            <td>
              {{-- カテゴリ名のテキスト表示 --}}
              {{ $todo->category ? $todo->category->name : '未分類' }}
            </td>
            <td>
              <button type="submit" class="todo-btn-blue">更新</button>
              </form>
              <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="todo-inline-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="todo-btn-red">削除</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endsection