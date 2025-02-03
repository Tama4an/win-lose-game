# Инструкция по развертыванию

## 📌 Требования
Перед началом убедитесь, что у вас установлены:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## 🚀 Запуск проекта
### 1. Клонирование репозитория
Сначала клонируйте репозиторий с проектом:
```sh
git clone https://github.com/Tama4an/win-lose-game.git
cd win-lose-game
```

### 2. Запуск контейнеров
Соберите и запустите контейнеры:
```sh
docker-compose up -d --build
```

### 3. Установка зависимостей
После запуска контейнеров заходим внутрь контейнера:
```sh
docker exec -it nux_game_app bash
```
Затем копируем файл с настройками окружения:
```sh
cp .env.example .env
```
Устанавливаем зависимости:
```sh
composer install
```
Генерируем ключ приложения:
```sh
php artisan key:generate
```
Выполняем миграции базы данных:
```sh
php artisan migrate
```

### 4. Проверка работы
После запуска контейнеров проверьте работу проекта:
```sh
docker ps
```
Затем откройте браузер и перейдите по адресу:
```
http://localhost:8000
```

## 🛠 Основные команды

### Остановка контейнеров
```sh
docker-compose down
```

### Перезапуск с очисткой кеша
```sh
docker-compose down -v
```

### Запуск команд Artisan в контейнере
```sh
docker-compose exec app php artisan migrate
```

```sh
docker-compose exec app php artisan tinker
```

### Доступ к MySQL через контейнер
```sh
docker-compose exec db mysql -u root -p
```

### Логи контейнера Laravel
```sh
docker-compose logs -f app
```


## 🏆 Готово!
Теперь ваш Laravel-проект полностью работает в Docker! 🎉

