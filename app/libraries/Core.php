<?php
//core app class

class Core {
    protected $currentController = 'careu';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        // print_r($this->getUrl());
        $url = $this->getUrl();
        if(isset($url[0]))
        {
            session_start();
            if($url[0]=="careu"){
                if(file_exists('../app/controller/'.ucwords($url[0]).'.php'))
                {
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }else if(isset($_SESSION["adminUserName"]) && $url[0]=="careuadmin" ){
                if(file_exists('../app/controller/'.ucwords($url[0]).'.php'))
                {
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }else if(isset($_SESSION["policeUserName"]) && $url[0]=="police" ){
                if(file_exists('../app/controller/'.ucwords($url[0]).'.php'))
                {
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }else if(isset($_SESSION["suwasariyaUserName"]) && $url[0]=="suwasariya"){
                if(file_exists('../app/controller/'.ucwords($url[0]).'.php'))
                {
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }else{
                $_SESSION["notallowed"]="true";
            }
        }

        require_once '../app/controller/'.$this->currentController.'.php';
        $this->currentController = new $this->currentController;

        //check for the second part of the url
        //the method inside the controller
        if(isset($url[1]))
        {
            if(method_exists($this->currentController,$url[1]))
            {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        //get params from url
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }
}

?>