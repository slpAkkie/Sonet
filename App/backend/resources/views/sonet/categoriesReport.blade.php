<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .color-sign {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 15px;
        }
    </style>
    <title>Отчет</title>
</head>
<body>
    <h1>Отчет по категориям</h1>
    <div><b>Всего категорий:</b> {{ $user->categories()->count() }}</div>
    <br>
    <ul>
        @foreach($user->categories()->orderByDesc('created_at')->get() as $category)
            <li>{{ $category->title }} ({{ $category->notes()->count() }} заметок) <span class="color-sign" style="background-color: {{ $category->color }}"></span> [Создана: {{ $category->created_at }}]</li>
        @endforeach
    </ul>
</body>
</html>
