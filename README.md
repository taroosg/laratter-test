# G's ACADEMY デプロイフェイズ（Laravel）サンプルプロダクト

## How to use

```bash
git clone REPOSITORY_URL
```

```bash
cd laratter-test
```

## 必要なディレクトリの作成

このまま起動すると必要なディレクト入りがなくてエラーになる．

そのため，下記コマンドを順に実行して必要なディレクトリを作成する．

```bash
mkdir -p storage/framework/cache/data/
mkdir -p storage/framework/app/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
```

## コンテナ動作に必要なファイルをダウンロード & インストール

Laravel Sail の実行に必要な vendor ディレクトリは Git では管理されていない．そのため，コマンドを実行して用意する必要がある．

下記コマンドを実行すると自動的に全部入る．6 行まとめて入力して実行すること．

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

```

参考: [https://readouble.com/laravel/10.x/ja/sail.html](https://readouble.com/laravel/10.x/ja/sail.html)

## env ファイルの準備

下記コマンドで準備する．

```bash
cp .env.example .env
```

`.env` ファイルの `DB_` で始まる行を以下のように変更する

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laratter-test
DB_USERNAME=sail
DB_PASSWORD=password
```

`DB_USERNAME` と `DB_PASSWORD` が DB のアクセス情報となる．phpmyadmin もこの情報でログインすることとなる．

## 動作確認

下記コマンドでコンテナを立ち上げる

```bash
./vendor/bin/sail up -d
```

立ち上がったら下記コマンドを順に実行し，アプリケーションの準備を整える．

```bash
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate

# テストユーザ作成
./vendor/bin/sail php artisan db:seed --class=UserSeeder

```

ブラウザから `localhost` にアクセスするとアプリケーションの動作が確認できる．

また，`localhost:8080` にアクセスすると phpmyadmin にアクセスできる．

コンテナ終了させるときは下記コマンドを実行する．

```bash
./vendor/bin/sail down
```
