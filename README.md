# php デモプレームワーク

**「パーフェクトPHP」**の**「Part3 実践Webアプリケーション」**のソース。


# このフレームワークを使った際の開発内容

* Application class
  * ルートディレクトリの設定
  * アクションにあわせたルーティング設定
  * 接続するデータベースの指定（DbManagerクラスを操作）
  * ログインアクションの指定

* index.php
  * Applicationの呼び出しと実行

* Controller class (Controller)
  * 役割に合わせて子クラスの作成
  * 作成する画面にあわせたアクション定義、処理の実装
  * ログインが必要なアクションの指定

* DbRepository class (Model)
  * データベース上のテーブルごとに子クラスの作成
  * データベースアクセス処理の実装

* View file (View)
  * アクションに合わせたHTMの記述
  * レイアウトファイルの記述
