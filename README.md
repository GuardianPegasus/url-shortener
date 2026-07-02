# Сокращатель ссылок

Веб-приложение на Laravel 11 + Filament v3 для создания коротких ссылок, отслеживания переходов и логирования статистики.

## Стек
* PHP 8.3+
* Laravel 11
* Filamentphp v3
* Docker
* Laravel Sail
* MySQL

## Особенности
* Реализован полноценный личный кабинет на базе Filament v3 с возможностью самостоятельной регистрации пользователей.
* Автоматическая генерация уникальных 6-значных кодов для ссылок.
* Защита от дублирования кодов на уровне БД через уникальный индекс.
* Сбор детальной статистики по каждому переходу с выводом таблицы через Relation Manager внутри ЛК.
* Пользователи видят и могут удалять только свои ссылки.

## Как запустить проект локально

1. Клонируйте репозиторий:
```bash
git clone https://github.com/GuardianPegasus/url-shortener
```
```bash
cd url-shortener
```
2. Создайте файл окружения:
```bash
cp .env.example .env
```
3. Запустите Docker-контейнеры через Laravel Sail:
```bash
./vendor/bin/sail up -d
```
4. Установите зависимости и сгенерируйте ключ:
```bash
./vendor/bin/sail composer install
```
```bash
./vendor/bin/sail artisan key:generate
```
5. Накатите миграции:
```bash
./vendor/bin/sail artisan migrate
```
6. Перейдите по адресу "http://localhost/admin", нажмите Sign up и создайте аккаунт.