## Features

- 後端 https://github.com/Oliver-Guo/laravel-vue-api Laravel 5.5 + Authentication with JWT 
- 前端 https://github.com/Oliver-Guo/laravel-vue-admin Vue + VueRouter + Vuex + ESlint + element-ui + Font Awesome 5 

## Installation 後端
  	
- 修改 `.env` 設定
- `php artisan key:generate` and `php artisan jwt:secret`)
- 不使用 `php artisan migrate` 直接 import demo.sql 因為要demo權限 並搭配前端

## Installation 前端
  	
- npm install

## Usage 前端

#### Development

```bash
# build and watch
npm run dev
```

#### Production

```bash
npm run build
```

## 說明

#### 功能

- 作者(上傳圖片)
- 專題分類(拖拉排序)
- 專題(上傳圖片、關聯文章、關聯TAG)
- 權限管理

	後端 laravel-vue-api		
	檔案路徑\app\Http\Controllers\Api\Admin\AuthController.php 的funtion me 

	前端 laravel-vue-admin
	檔案路徑\src\permission.js	 
   		    \src\views\layout\components\Sidebar\SidebarItem.vue

    舉例說明
    後端
    DB permissions table 權限判斷欄位為 name  ex:author_list 判斷 作者列表
    前端
    使用者登入後 透過 get api/admin/me 取得 auths 然後存入 vuex 的 user.auths
    然而 api/admin/me response 會把權限 author_list -> AuthorList 輸出
    再搭配 \src\router\index.js vue-router name 的命名 就為 AuthorList 需一致
    這時 src\permission.js	使用 router.beforeEach 去匹配 vuex的user.auths 和 vue-router name 
    這時 vue-router 切換路徑判斷權限就完成了，接下來是左邊選單列權限判斷是否顯示 
    \src\views\layout\components\Sidebar\SidebarItem.vue 搭配 vuex 的 user.auths 判斷
    另外部分頁面需判斷是否可新增、編輯、刪除 用 v-if 搭配 vuex 的 user.auths 判斷
    可看 \src\views\author\list.vue 判斷新增就用AuthorAdd 刪除就用 AuthorDel
    結論 後端傳送的 auths 與 vue-router name 的命名 匹配判斷

    切成前後端為兩個專案也比較好維護，因為都變成獨立的專案。
    若用laravel webpack.mix.js，還要依賴 laravel-mix。
