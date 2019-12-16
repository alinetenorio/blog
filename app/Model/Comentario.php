<?php

	class Comentario{


		public static function  selecionarTodos($id_postagem){
			$conexao = Conexao::getConexao();
			

			$sql = "SELECT * FROM comentario WHERE id_postagem=:id_postagem";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':id_postagem', $id_postagem, PDO::PARAM_INT);
			$sql->execute();

			$resultado = array();

			while($row = $sql->fetchObject("Comentario")){
				$resultado[] = $row;
			}

			return $resultado;
		}
	}
