<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Отчет</title>
</head>
<body>
    <h1>Отчет пользователя</h1>
    <div><b>Имя:</b> {{ $user->first_name }}</div>
    <div><b>Фамилия:</b> {{ $user->last_name }}</div>
    <div><b>Логин:</b> {{ $user->login }}</div>
    <div><b>Почта:</b> {{ $user->email }}</div>
    <div><b>Дата регистрации:</b> {{ $user->created_at }}</div>
    <div><b>Дата последнего изменения профиля:</b> {{ $user->updated_at }}</div>
    <br>
    <h2>Активные токены</h2>
    <ul>
        @foreach($user->tokens as $token)
            <li>{{ $token->user_agent }} <small>(Создан: {{ \Illuminate\Support\Carbon::make($token->created_at)->format('d.m.Y H:i') }}; Последнее использование: {{ \Illuminate\Support\Carbon::make($token->updated_at)->format('d.m.Y H:i') }})</small></li>
        @endforeach
    </ul>

    <h2>Общая статистика</h2>
    <div><b>Создано заметок:</b> {{ $user->notes()->count() }}</div>
    <div><b>Из них вы дали доступ к:</b> {{ $user->notes()->whereHas('contributors')->count() }}</div>
    <div><b>Вам открыт доступ к:</b> {{ $user->contributorIn()->count() }}</div>
    <br>
    <div><b>Загруженных вложений:</b> {{ \App\Models\Attachment::whereHas('note', function (\Illuminate\Database\Eloquent\Builder $query) use ($user) {
        $query->where('user_id', $user->id);
    })->count() }}</div>
    <br>
    <div><b>Создано папок:</b> {{ $user->folders()->count() }}</div>
    <div><b>Создано категорий:</b> {{ $user->categories()->count() }}</div>
    <br>
    <div><b>Оставлено комментариев:</b> {{ $user->comments()->count() }}</div>
</body>
</html>
