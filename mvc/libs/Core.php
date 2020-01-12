<?php

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'windex';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        //look in the contrillers for the first value
        if (isset($url[0]) && file_exists('../mvc/controllers/'.$url[0].'.php'))
        {
            //if exist set it as current controller
            $this->currentController = ucwords($url[0]);
            //unset value at index 0 bc we don't need it enymore
            unset($url[0]);
        }

        //require the controller
        require_once '../mvc/controllers/'.$this->currentController.'.php';
        //instantiate the current controller
        $this->currentController = new $this->currentController;
        //check for second parms in methods
        if (isset($url[1]))
        {
            $url[1] = 'w'.$url[1];
            if (method_exists($this->currentController, $url[1]))
            {
                $this->currentMethod = $url[1];
                //unset index 1
                unset($url[1]);
            }
        }
        //het any params
        $this->params = $url ? array_values($url) : [] ;
        // call a callback  with array of params
        call_user_func_array([$this->currentController,$this->currentMethod], $this->params);
    }
    public function getUrl()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }

} 