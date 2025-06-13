@extends('layouts.app')
@section('css')

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
      value="{{ old('content') }}" />
    <select name="category_id" id="category_id" class="todo-select">
      <option value="">カテゴリーを選択</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="create-form__button">
    <button class="create-form__button-submit" type="submit">作成</button>
  </div>
</form>
{{-- ローカルスコープを使用し検索処理 --}}
<div class="section__title">
  <h2>Todo検索</h2>
</div>

<form class="search-form" action="/todos" method="get">
  @csrf
  <div class="search-form__item">
    <input class="search-form__item-input" type="text" name="content" value="{{ request('content') }}" />
    <select name="category_id" id="category_id" class="todo-select">

      <option value="">カテゴリーを選択</option>
      @foreach($categories as $category)category
      <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}> {{ $category->name }}
      </option>
      @endforeach
    </select>

    <button class="search-form__button-submit" type="submit">検索</button>
  </div>
</form>

{{-- カテゴリー一覧 --}}
<div class="section__title">
  <h2>カテゴリー一覧</h2>
  <ul class="category-list">
    @foreach ($categories as $category)
    <li class="category-list__item">
      {{ $category->name }}
    </li>
    @endforeach
  </ul>
</div>
{{-- カテゴリー削除 --}}
<div class="section__title">
  <h2>カテゴリー削除</h2>
  <form class="delete-form" action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="post">
    @csrf
    @method('DELETE')
    <div class="delete-form__item">
      <select name="id" id="id" class="todo-select">
        <option value="">削除するカテゴリーを選択</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="delete-form__button">
      <button class="delete-form__button-submit" type="submit">
        削除
      </button>
    </div>
  </form>
</div>
@endsection