<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Отчет</title>
</head>
<body>
    <h1>Отчет по комментариям</h1>
    <div><b>Всего комментариев:</b> {{ $user->comments()->count() }}</div>
    <div><b>Под:</b> {{ $user->comments()->groupBy('note_id')->count() }} заметками</div>
    <div><b>В среднем символов:</b> {{ \App\Models\Comment::selectRaw('ROUND(AVG(`lens`.`len`), 2) AS `avg_len`')->from($user->comments()->selectRaw('LENGTH(`body`) AS `len`'), 'lens')->first('avg_len')->avg_len }}</div>
    <br>
    <h2>Первый комментарий</h2>
    {{ $user->comments()->where('created_at', $user->comments()->min('created_at'))->first()->body }}
    <br>
    <h2>Последний комментарий</h2>
    {{ $user->comments()->where('created_at', $user->comments()->max('created_at'))->first()->body }}
    <br>
    <h2>Комментарии оставлены под заметками</h2>
    <ul>
        @foreach(\App\Models\Note::whereIn('id', $user->comments()->select('note_id'))->get() as $note)
            <li>{{ $note->title }} (Комментариев: {{ $note->comments()->where('user_id', $user->id)->count() }})</li>
        @endforeach
    </ul>
</body>
</html>
