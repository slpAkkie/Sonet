<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Отчет</title>
</head>
<body>
    <h1>Отчет по заметкам</h1>
    <div><b>Всего заметок:</b> {{ $user->notes()->count() }}</div>
    <div><b>С вложениями:</b> {{ $user->notes()->whereHas('attachments')->count() }}</div>
    <div><b>Самая ранняя заметка создана:</b> {{ $user->notes()->min('created_at') }}</div>
    <div><b>Самая поздняя заметка создана:</b> {{ $user->notes()->max('created_at') }}</div>
    <br>
    <div><b>В среднем символов:</b> {{ \App\Models\Note::selectRaw('ROUND(AVG(`lens`.`len`), 2) AS `avg_len`')->from($user->notes()->selectRaw('LENGTH(`body`) AS `len`'), 'lens')->first('avg_len')->avg_len }}</div>

    <h2>Эти пользователи имеют доступ к вашим заметкам</h2>
    <ul>
        @foreach(\App\Models\User::whereIn('id', function(\Illuminate\Database\Query\Builder $query) use ($user) {
            $query->from('note_users')->select('user_id')->whereIn('note_id', function (\Illuminate\Database\Query\Builder $query) use ($user) {
                $query->from('notes')->select('id')->where('user_id', $user->id);
            });
        })->get() as $userWithAccess)
            <li>{{ $userWithAccess->getFullName() }} ({{ $userWithAccess->email }})</li>
        @endforeach
    </ul>
</body>
</html>
