
# Siginificados dos arquivos


	# Paginas para o cliente
		index.php 	 		pagina inicial do usuario.
		chamada.php  		pagina de chamada.
		escolha_ativ.php	pagina de exibição das atividades criadas no 'criar_ativ.php'.
		criar_ativ.php		pagina de criação de avaliações.
		alteranomes.php		pagina de exibição, alteração e inserção dos nomes dos alunos.
		configurar.php		pagina de configuração de parametros (Trimestres).
		altera_chamada.php  pagina de alteracao do conteudo das aulas.
        avaliacao.php		pagina de inserção de notas dos alunos.
		altera_chamada.php	pagina de alteração do alias da chamada

	# Paginas do servidor
		saida.php			codigo de aniquilação de variaveis da seção ($_SESSION).
		salvar_conf.php		salva os parametros inseridos pelo usuario no 'configurar.php'.
		gravachamada.php	salva os parametros de 'chamada.php'.
		gravaavaliacao.php	salva os parametros de 'avaliacao.php'.
			grava_ativ.php		salva os parametros de 'criar_ativ.php'.
		del_ativ.php		destroi a atividade gravada pelo 'grava_ativ.php'.
		adic_turma.php		cria um turma para o usuario.
		apagaturma.php		apaga as turmas cadatradas criadas pelo 'adic_turma.php'.
		alter.php			altera ou insere os nomes dos alunos do 'alteranomes.php'.
===========================
gerar PDF


gerar_html_avaliacao.php	retorna o html para a criação da tabela de avaliação para o 'gerar_pdf_avaliacao.php'.
gerar_html_pres.php			retorna o html para a criação da tabela de presença para o 'gerar_pdf_pres.php'.



	# Pasta include_prof
		define.php			substitui o caminho dos includes.
		header.php			cabeçalho da pagina 'index.php'.
