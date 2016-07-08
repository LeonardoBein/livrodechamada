<?php require ("header.php"); ?>
<div id='conteudo'>
<input name="turma" type="hidden" value="<?=$_G['class'] ?>">
<input name="disciplina" type="hidden" value="<?=$_G['discipline'] ?>">

  <p>
    <div id="adicionaturma" align="center">
      <form id="adic">
        <p id="resposta"></p>
        <label for="input_turma">Adicionar Turma:</label><br />
        <input id="input_turma" class="turma" type="text" name="turma" maxlength="50" onkeypress="mascara(this,turma_for);" autofocus/><br/><br/>
        <label for="input_disciplina">Disciplina:</label><br/>
        <input id="input_disciplina" class="disciplina" type="text" name="disciplina" maxlength="50" onkeypress="mascara(this,turma_for);"/><br/>
        <input class="button blue" type="submit" value="Adicionar" />
      </form>
   </div>
  </p>

<div id="tabela">
    <div id="turma-index">Turma</div>
    <div id="disciplina-index">Disciplina</div>
    <div id="editar">Editar</div>
    <div id="more-info">Em breve</div>
    <div id="apaga">Excluir</div></br>
<?php list_class($_SESSION['usuarioLogin']);  ?>
</div>
</div>
<?php require("rodape.php"); ?>
