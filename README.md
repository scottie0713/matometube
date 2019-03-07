-----------------------------------
  まとめちゅーぶ　本番環境設定
-----------------------------------
1. laravelのホームディレクトリに移動

2. composer installでvendorディレクトリを作成
$ composer install

3. application keyを作ります
$ php artisan key:generate 

4. DBを作ります
$ php artisan migrate

5. strageへのシンボリックリンクを貼ります
$ php artisan storage:link

これで動くはず