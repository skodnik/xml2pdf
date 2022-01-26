## Установка
```bash
git clone git@github.com:skodnik/xml2pdf.git xml2pdf
cd xml2pdf
composer install
```

## Настройка
В директории `data` разместить необходимые xml документы.
В файле `go.php` в массиве `$xmls` перечислить их имена.
В переменной `$structure` определить структуру финально `xml` документа. Заполнить ее значениями массива `$result`.

## Запуск
```bash
php go.php
```

Файл `result.pdf` будет помещен в директорию `data`.