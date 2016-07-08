<?php
get_trimestre($_SESSION['usuarioLogin']);



switch (strtolower($_G['action'])) {
  case    'index':                  require("default.php");                break; # pagina princiapl
  case    'add_classes':            require('add_classe.php');             break; # cria turma
  case    'del_classes':            require('del_classe.php');             break; # deleta turma
/*--path call school--*/
  case    'chamada':                require("chamada.php");                break; # pagina principal chamada
  case    'list_content_call':      require("content_call_school.php");    break; # 1/2 pagina mostra chamadas realizadas
  case    'save_call':              require("save_call.php");              break; # troca alias da chamada
/*--------*/
/*--Alunos--*/
  case    'alunos':                 require("students.php");               break; #  pagina lunos
  case    'alterar_alunos':         require("change_students.php");        break; # altera nomes alunos
/*--------*/
/*--Avaliaçoes--*/
  case    'avaliacao':              require("evaluantion.php");            break; # pagina mostra atividade
  case    'cria_avaliacao':         require("add_evaluantion.php");        break; # pagina criar atividade
  case    'salva_avaliacao':        require("save_evaluantion.php");       break; # salva avaliacoes criadas
  case    'atividade':              require("activity.php");               break; # pagina da atividade
  case    'del_atividade':          require("del_activity.php");           break; # deleta ativiade
  case    'salva_atividade':        require("save_activity.php");          break; # deleta ativiade
/*---------*/
/*--Relatorios--*/
  case    'relatorio':              require("report.php");                 break; # pagina relatorio
/*---------*/
/*--Config--*/
  case    'configuracao':           require("config.php");                 break; # pagina configuracao
/*---------*/
  case    '404':                    require("404.php");                    break; # pagina 404
  default:                          error(404);                    break; # paguina nao encontrada
}






?>
