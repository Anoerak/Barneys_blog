<?php

require_once './templates/view.php';
require_once './src/controllers/constructor/ControllerConstructor.php';


class Router
{

    private $ctrlConstructor;
    private $page;
    private $action;
    private $option;
    private $id;

    public function __construct()
    {
        $this->ctrlConstructor = new ControllerConstructor();
        $this->page = $_GET['page'] ?? null;
        $this->action = $_GET['action'] ?? null;
        $this->option = $_GET['option'] ?? null;
        $this->id = $_GET['id'] ?? null;
    }

    // We loop through the array and check the value of the key
    public function routerRequest()
    {
        try {
            if (empty($this->page)) {
                $this->ctrlConstructor->buildControllerMethod('home', null, null, null);
            } else {
                $this->ctrlConstructor->buildControllerMethod($this->page, $this->action, $this->option, $this->id);
            }
        } catch (Exception $e) {
            Tools::error($e->getMessage(), $e->getCode());
        }
    }
}