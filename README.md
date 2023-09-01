# Исправленная версия 

https://github.com/ProgTosya/Employee/assets/110400557/3e1bdf0b-ca53-423d-a455-ce99b200a0d2
## Установка
Перед установкой обновить .env файл
- composer install
- npm install
- php artisan migrate
- php artisan db:seed
- php artisan serve
- npm run dev
### После заполнения БД 
- Login: admin@admin.by
- Password: password
## файл .env
- DB_CONNECTION=pgsql
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=Employees
- DB_USERNAME=postgres
- DB_PASSWORD=password

## Использование 

После установки пользователя перенаправляет на главную страницу. На ней расположенна карточка генерального директора и возможность авторизации/регистрации. При нажатии на карточку генерального директора открывается список его подчинённых. При нажатии на каждого сотрудника подгружается список его подчинённых.
На видео выше реализован процесс d&d сотрудников, пользователь перетягиванием меняет начальника для сотрудника. Перетягивать нельзя только генерального директора.
Данные для авторизации указаны выше.

После авторизации пользователя направляет на страницу CRUD взаимодействия. Реализован поиск для каждой колонки таблицы. Сортировка работает без перезагрузки страницы, для каждой колонки.
Есть возможность смены генерального директора, для этого нужно знать табельный номер нового генерального директора. При нажатии на кнопку создания нового сотрудника перенаправляет на страницу для добавления в БД сотрудника. Все поля являются обязательными для заполнения. Также добавление фотографии. 
Для редактирование сотрудников в таблице напротив данных сотрудника есть символ маркера. При нажатии открывается страница пользователя с  его данными для редактирования, с отображением фотографии сотрудника. 

Для перенаправления на главную страницу в правом верхнем углу экрана при нажатии на имя пользователя -> на главную 


