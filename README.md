**Описание**
Скрипт, находит список пользователей, потративших сумму выше или равную заданному порогу и дату, когда это событие наступило.

**Требования**
- Скрипт должен быть написан на чистом PHP
- Дополнительное решение при помощи bash или SQL будет плюсом
- Скрипт должен запускаться из командной строки
- Скрипт должен принимать 2 аргумента: 1-й - имя файла, 2-й - пороговая сумма

**Развертывание придложенной конфигурации:**
1. Клонировать репозиторий с GitHub и проверяем конфигурацию для Docker  и зависящие от него, настройки для БД
    - файл docker-compose.yml
    - файл config/MySQLConfiguration.php
2. Запускаем docker-compose
    - `docker-compose build`
    - `docker-compose up`
3. Устанавливаем зависимости Composer
    - `composer install`
4. Загружаем данные в БД
- для таблицы dataset_big данные из файла dataset-big.csv
- для таблицы dataset_small данные из файла dataset-small.csv

**Использование**
- `php index.php dataset-big.csv 2000` 
(источник данных - соответствующие файлы в корне проекта)
- `php index.php dataset-big.csv 2000 sql` 
(источник данных - соответствующие таблицы в БД)