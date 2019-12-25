<?php

	namespace App\Model;
	use lib\Database\Conexao;
	use \Exception;
	
	class Comentario{


		public static function  selecionarTodos($id_postagem){
			$conexao = Conexao::getConexao();
			

			$sql = "SELECT * FROM comentario WHERE id_postagem=:id_postagem";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':id_postagem', $id_postagem);
			$sql->execute();

			$resultado = array();

			while($row = $sql->fetchObject(Comentario::class)){
				$resultado[] = $row;
			}

			return $resultado;
		}
		
		public static function  insert($params){
			$conexao = Conexao::getConexao();
			

			$sql = "INSERT INTO comentario (autor, conteudo, id_postagem) VALUES (:nome, :comentario, :id_post)";
			
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':id_post', $params['id_postagem']);
			$sql->bindValue(':nome', $params['nome']);
			$sql->bindValue(':comentario', $params['comentario']);
			
			$resultado = $sql->execute();

			if($resultado == false){
				throw new Exception("Falha ao adicionar");
			}
			return true;
		}
	}
