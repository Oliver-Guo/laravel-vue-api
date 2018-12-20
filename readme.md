## Features

- 後端 https://github.com/Oliver-Guo/laravel-vue-api Laravel 5.5 + Authentication with JWT 
- 前端 https://github.com/Oliver-Guo/laravel-vue-admin Vue + VueRouter + Vuex + ESlint + element-ui + Font Awesome 5 
- 作者(上傳圖片)
- 專題分類(拖拉排序)
- 專題(上傳圖片、關聯文章、關聯TAG)
- 權限管理

## Installation
- composer install
- 權限目錄修改 storage 及 bootstrap/cache 及 public/upload  
- 修改 `.env` 設定
- `php artisan key:generate`
- `php artisan jwt:secret`
- `php artisan migrate:install`
- `php artisan migrate`
- `php artisan db:seed --class=DatabaseSeeder`
