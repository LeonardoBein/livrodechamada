<?php

/**
 *
 */
class matematica{


/* funcao que determina o limite de avaliacoes por trimestre
*
* @param  float  $soma        The sum of reviews
* @param  float  $new_value   The new value
*
* @return boolean true or false 
*/
  public function limite_avaliacoes($soma,$new_value){
    if($soma > 10.00){
        return false;
    }
    elseif(($soma + $new_value) > 10.00){
        return false;

    }
    else {
      return true;
    }


  }
}






 ?>
