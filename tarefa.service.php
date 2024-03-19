<?php


//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;
	private $categoria;
	

	public function __construct(Conexao $conexao, Tarefa $tarefa, Tarefa $categoria) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
		$this->categoria = $categoria;
	}

	public function inserir() {
		// Query para inserir uma nova tarefa com sua categoria na tabela tb_tarefas
		$query = 'INSERT INTO tb_tarefas(tarefa, categoria) VALUES (:tarefa, :categoria)';
		$stmt = $this->conexao->prepare($query);
		
		// Vincular os valores das variáveis tarefa e categoria aos parâmetros da consulta
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->bindValue(':categoria', $this->categoria->__get('categoria'));
		
		// Executar a consulta preparada
		$stmt->execute();
	}
	

	public function recuperar() { //read
		$query = '
			select 
				t.id, s.status, t.tarefa , t.categoria
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update

		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasPendentes() {
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

?>