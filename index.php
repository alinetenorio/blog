<?php

#Faz os imports; chama o método start() do Core; salva os outputs
#	gerados em um buffer; substitui a area dinamica do template do site
#	pelo conteudo do buffer; imprime o template modificado
#index.php should be as bare-boned as you can make it because it will 
#	be re-sent every time a new page is loaded


#No index.php serão feitos todos os imports dos arquivos php

##VER AUTOLOAD DOC OMPOOSER
require_once 'app/Core/Core.php';

require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErroController.php';
require_once 'app/Controller/PostagemController.php';
require_once 'app/Controller/SobreController.php';
require_once 'app/Controller/AdminController.php';
require_once 'app/Model/Postagem.php';
require_once 'app/Model/Comentario.php';
require_once 'lib/Database/Conexao.php';
#Composer(dependency manager) handles autoloading automatically,  the following line of code
# 	will allow you to load all your referenced packages:
require_once 'vendor/autoload.php';



#Lê o arquivo passado e o retorna como string
$template = file_get_contents('app/Template/estrutura.html');



#ob_start: Ativa o output buffering. Salva tudo que normalmente seria printado na tela
#	->Start remembering everything that would normally be outputted, 
#	but don't quite do anything with it yet
#ob_get_contents(): Retorna tudo que foi salvo no buffer
#ob_end_clean(): para de salvar e descarta tudo que há no buffer
ob_start();
	
	$core = new Core;
	#$_GET: retorna um array associativo contendo os parametros e valores passados para o 
	# script atual atraves de uma URL
	$core->start($_GET);

	$saida = ob_get_contents();

ob_end_clean();

#procura a string {{area_dinamica}} no estrutura.html, e o substitui pela saída
#gerada pelo buffer.

$template_pronto = str_replace('{{area_dinamica}}', $saida, $template);

echo $template_pronto;