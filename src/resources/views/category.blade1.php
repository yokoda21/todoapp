@extends('layouts.app') 

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
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
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- カテゴリー一覧 --}}
    <div class="section__title">
      <h2>カテゴリー一覧</h2>
    </div>
    <ul class="category-list">
      @foreach($categories as $category)
          <li class="category-list__item">
              <a href="{{ route('category.show', ['id' => $category->id]) }}">{{ $category->name }}</a>
          </li>
      @endforeach
    </ul>
    <div class="section__title">
      <h2>カテゴリー新規作成</h2>
    </div>
    {{-- 新規作成フォーム --}}
    {{-- コントローラーに値を送信 --}}
    <form class="create-form" action="{{ route('category.store') }}" method="post">
      @csrf
      <div class="create-form__item">
        <input
          class="create-form__item-input"
          type="text"
          name="name"
          value="{{ old('name') }}"
          placeholder="カテゴリー名を入力"
        />        
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
        <form class="update-form" action="{{ route('category.update', ['id' => $category->id]) }}" method="post">
          @csrf
          @method('PUT')
          <div class="update-form__item">
            <input
              class="update-form__item-input"
              type="text"
              name="name"
              value="{{ old('name', $category->name) }}"
              placeholder="カテゴリー名を入力"
            />
          </div>
          <div class="update-form__button">
            <button class="update-form__button-submit" type="submit">更新</button>
          </div>
        </form>
    