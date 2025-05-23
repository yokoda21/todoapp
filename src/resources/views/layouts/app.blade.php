<!DOCTYPE html>
<html lang="ja">
<head>
    
    <meta charset="UTF-8">
    <title>@yield('title', 'Todoアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <div class="page-title-wrapper">
                <h1 class="page-title">@yield('header', 'Todo')</h1>
            </div>
        </header>
        @yield('content')
    </div>
</body>
</html>

<!-- ChatGPTからの提案で作成+Copilotの提案で修正（スタイルタグの削除）。resources/views/layouts/app.blade.php -->