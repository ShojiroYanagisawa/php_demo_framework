<?php

class Router
{
  protected $routes;

  public function __construct($definitions)
  {
    $this->routes = $this->compileRoutes($definitions);
  }


  // ルーティング定義配列中の動的パラメータ指定(:idなど)を正規表現で扱えるようにする
  public function compileRoutes($definitions)
  {
    $routes = array();

    foreach ($definitions as $url => $params) {
      // URLの区切り文字は / なので、explode()で / で分割
      $tokens = explode('/', ltrim($url, '/'));
      foreach ($tokens as $i => $token) {
        if (0 == strpos($token, ':')) {
          $name = substr($token, 1);
          // : で始まる文字列が合った場合、正規表現の形式に変換する
          $token = '(?P<' . $name . '>[^/]+)';
        }
        $tokens[$i] = $token;
      }

      $pattern = '/' . implode('/', $tokens);
      $routes[$pattern] = $params;
    }

    return $routes;
  }


  // 変換済みのルーティング定義配列とPATH_INFOのマッチングを行い、
  // パラメーターの特定を行う
  public function resolve($path_info)
  {
    // PATH_INFOの先頭がスラッシュでない場合、先頭にスラッシュを付与
    if ('/' !== substr($path_info, 0, 1)) {
      $path_info = '/' . $path_info;
    }

    foreach ($this->routes as $pattern => $params) {
      // コンパイル済みのルーティング定義配列に対して正規表現を用いてマッチング
      if (preg_match('#^' . $pattern . '$#', $path_info, $matches)) {
        // マッチした場合、params変数にマージし返す
        $params = array_merge($params, $matches);
        return $params;
      }
    }

    return false;
  }
}
