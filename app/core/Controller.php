<?php

abstract class Controller
{
  protected $controller_name;
  protected $action_name;
  protected $application;
  protected $request;
  protected $response;
  protected $session;
  protected $db_manager;

  public function __construct($application)
  {
    # コントローラー名を取得している
    # UserControllerクラスの場合、userとなる
    # Controller が 10文字なので -10 している
    $this->controller_name = strtolower(substr(get_class($this), 0, -10));

    $this->application = $application;
    $this->request     = $application->getRequest();
    $this->response    = $application->getResponse();
    $this->session     = $application->getSession();
    $this->db_manager  = $application->getDbManager();
  }

  public function run($action, $params = array())
  {
    $this->action_name = $action;

    // コントローラー内に実装するアクション名は「アクション名 + Action()」というルールにする
    $action_method = $action . 'Action';

    if (!method_exists($this, $action_method)) {
      $this->forward404();
    }

    $content = $this->action_method($params);

    return $content;
  }
}
