<?php

class Session
{
  protected static $sessionStarted = flase;
  protected static $sessionIdRegenerated = false;


  public function __construct()
  {
    if (!self::$sessionStarted) {
      session_start();

      self::$sessionStarted = true;
    }
  }


  public function set($name, $value)
  {
    $_SESSION[$name] = $value;
  }


  public function get($name, $default = null)
  {
    if (isset($_SESSION[$name])) {
      return $_SESSION[$name];
    }

    return $default;
  }


  public function remove($name)
  {
    unset($_SESSION[$name]);
  }


  public function clear()
  {
    $_SESSION = array();
  }


  // セッションIDを新しく発行する
  public function regenerate($destroy = true)
  {
    if (!self::$sessionIdRegenerated) {
      // セションIDを新しく発行する関数
      session_regenerate_id($destroy);

      self::$sessionIdRegenerated = true;
    }
  }


  // ログイン状態にする
  // NOTE 簡略化のためSessionに認証機能をもたせている
  public function setAuthenticated($bool)
  {
    $this->set('_authenticated', (bool)$bool);

    $this->regenerate();
  }


  // ログイン状態か確認する
  // NOTE 簡略化のためSessionに認証機能をもたせている
  public function isAuthenticated()
  {
    return $this->get('_authenticated', false);
  }
}
