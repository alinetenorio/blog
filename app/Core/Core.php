<?php

	#Identifica qual pagina o usuário está acessando e qual ação ele deseja fazer
	#Chama a classe do controlador e funções correspondentes
	class Core
	{
	
		#$urlGet = Contém os parametros e valores da URL atual
		public function start($urlGet){

			#Se o parâmetro 'todo' está setado, armazena o valor desse parametro em $acao
			#caso não esteja, $acao = index
			if(isset($urlGet['todo'])){
				$acao = $urlGet['todo'];
			}else{
				$acao = 'index';
			}
			
			#Se pagina está setada, guardar a pagina de Controller em $controller
			#ucfirst: transforma a primeira letra de uma string em maiúscula
			#caso a pagina não seja informada, o Controller default é o home
			if(isset($urlGet['pagina'])){
				$controller = ucfirst($urlGet['pagina']).'Controller';
			}else{
				$controller = 'HomeController';
			}
			

			if(!class_exists($controller)){
				$controller = 'ErroController';
			}
			
			if (isset($urlGet['id']) && $urlGet['id'] != null) {
				$id = $urlGet['id'];
			} else {
				$id = null;
			}

			
			#call_user_func_array: Chama um callback com um array de parâmetros
			#call_user_func_array($callback, $param_array)
			#Call the $[pagina]Controller->acao() method with parameter: $urlGet 
			# if $urlGet exists and it's diferent from null or null, otherwise 
			call_user_func_array( array(new $controller, $acao), array('id' => $id) );

			
		}


	}
