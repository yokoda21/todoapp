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

<div class="category__content">
  {{-- 新規作成フォーム --}}
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

  {{-- カテゴリー一覧テーブル --}}
  <div class="category-table">
    <table class="category-table__inner">
      <tr class="category-table__header-row">
        <th class="category-table__header">カテゴリー名</th>
        <th class="category-table__header">操作</th> {{-- 操作カラム --}}
      </tr>
      @foreach ($categories as $category)
      <tr class="category-table__row">
        <td class="category-table__item">
          {{-- インライン編集input --}}
          <form id="update-form-{{ $category->id }}" action="{{ route('categories.update', ['id'=>$category->id]) }}" method="post" style="display:flex;">
            @csrf
            @method('PATCH')
            <input
              class="update-form__item-input"
              type="text"
              name="name"
              value="{{ old('name', $category->name) }}"
              placeholder="カテゴリー名を入力" />
          </form>
        </td>
        <td class="category-table__item action-cell">
          <div class="button-group">
            <button form="update-form-{{ $category->id }}" class="update-form__button-submit" type="submit">更新</button>
            <form class="delete-form" action="{{ route('categories.destroy', ['id'=>$category->id]) }}" method="post" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="delete-form__button-submit" type="submit">削除</button>
            </form>
          </div>
        </td>
      </tr>


      @endforeach
    </table>
  </div>
</div>
@endsection