@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/category.css') }}">
{{--<link rel="stylesheet" href="{{ asset('css/reset.css') }}" />--}}
@endsection

@section('title', 'カテゴリー一覧')
@section('header')
カテゴリー一覧
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
<div class="category-alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    {{--入力失敗時の値を保持--}}
    <li>{{ old('name') }}</li>
    <li>{{ old('id') }}</li>
  </ul>
</div>
@endif

{{-- カテゴリー一覧 表示崩れている--}}
<div class="section__title">
  <h2>カテゴリー一覧</h2>

</div>
<div class="section__title">
  <h2>カテゴリー新規作成</h2>

</div>
{{-- 新規作成フォーム --}}
{{-- コントローラーに値を送信 --}}
<form class="create-form" action="{{ route('categories.store') }}" method="post">
  @csrf
  <div class="create-form__item">
    <input
      class="create-form__item-input"
      type="text"
      name="name"
      value="{{ old('name') }}"
      placeholder="カテゴリー名を入力" />
  </div>
  <div class="create-form__button">
    <button class="create-form__button-submit" type="submit">作成</button>
  </div>
</form>
<div class="update-form">
  <div class="section__title">
    <h2>カテゴリー更新</h2>
  </div>
  {{-- 更新フォーム --}}
  @foreach ($categories as $category)
  <form class="update-form" action="{{ route('categories.update', ['id' => $category->id]) }}" method="post">
    @csrf
    {{-- 更新するカテゴリーのIDを保持 --}}
    <div class="update-form__item">
      <input class="update-form__item-input" type="text" value="{{ $category['name'] }}">
    </div>
    <div class="update-form__button">
      <button class="update-form__button-submit" type="submit">更新する</button>
    </div>
  </form>
  @endforeach
  {{-- 削除フォーム --}}
  <div class="delete-form">
    <div class="section__title">
      <h2>カテゴリー削除</h2>
      <form class="delete-form" action="/todos/delete" method="post">
        @method('DELETE') @csrf
        <div class="delete-form__button">
          <button class="delete-form__button-submit" type="submit">
            削除
          </button>
        </div>
      </form>