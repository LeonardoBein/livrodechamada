<?php

class msg{

    private $bool_error= false;
    private $bool_msg= false;

    private $div_error = "

    <div class=\"error\" id=\"box_mess\">
        <p>%mensagem%</p>
    </div>

    ";

    private $div_msg = "

    <div class=\"msg\" id=\"box_mess\">
        <p>%mensagem%</p>
    </div>

    ";

    private $mensagem;

    public function true_msg($tipo){
        if($tipo == "error"){
            $this->bool_error = true;
        }
        if($tipo == "msg"){
            $this->bool_msg = true;
        }


    }

    public function mensagem($mensagem_input){

        $this->mensagem = $mensagem_input;





    }

    public function print_error(){

        if($this->bool_error == true){
            echo str_replace("%mensagem%", $this->mensagem, $this->div_error);
        }



    }

    public function print_msg(){

        if($this->bool_msg == true){
            echo str_replace("%mensagem%", $this->mensagem, $this->div_msg);

        }



    }
    public function _print(){
        self::print_error();
        self::print_msg();




    }




}




?>
