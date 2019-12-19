<?php

	namespace App\Controller;
	class ErroController{


		public function index($data){

			echo 'página de erro<br><br>';
			echo "Erro " . $data['errcode'];
			
		}

	}