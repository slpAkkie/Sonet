# SkyNotes

Web приложение для ведения заметок

## Описание

После регистрации и фхода в свой аккаунт SkyNotes позволяет:

- Просмотреть свои ноуты
- Создать/Удалять/Редактировать ноуты
- Поделиться ноутом с лругими пользователями
- Зашифровать ноуты

## Начало работы

Проект имеет в наличие сборку под Docker.

Скопируйте репозиторий

```bash
  git clone https://github.com/slpAkkie/sky-notes.git
```

И запустите сборку Docker-compose

```bash
  docker compose build
```

Теперь можно запустить контейнеры

```bash
  docker compose up
```

На вашем компьютере по адресам будут открыты:

- localhost (localhost:80) - Клиентская часть приложения
- localhost:8000 - API
- localhost:8080 - Adminer
- localhost:3306 - MariaDB

Для остановки и удаления контейнеров

```bash
  docker compose down
```

## Автор

Alexandr Shamanin (@slpAkkie)

## Лицензия

MIT

## Версия

`2.0.0`
