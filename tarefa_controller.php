<?php

require "tarefa.model.php";
require "tarefa.service.php";
require "conexao.php";


$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;


if ($acao == 'inserir') {
	$tarefa = new Tarefa();
	$categoria = new Tarefa();

	$tarefa->__set('tarefa', $_POST['tarefa']);
	$categoria->__set('categoria', $_POST['categoria']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);

	$tarefaService->inserir();

	header('Location: nova_tarefa.php?inclusao=1');
} else if ($acao == 'recuperar') {

	$tarefa = new Tarefa();
	$conexao = new Conexao();
	$categoria = new Tarefa();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	$tarefas = $tarefaService->recuperar();
} else if ($acao == 'atualizar') {

	$categoria = new Tarefa();
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_POST['id'])
		->__set('tarefa', $_POST['tarefa']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	if ($tarefaService->atualizar()) {

		if (isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');
		} else {
			header('location: todas_tarefas.php');
		}
	}
} else if ($acao == 'remover') {

	$categoria = new Tarefa();
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	$tarefaService->remover();

	if (isset($_GET['pag']) && $_GET['pag'] == 'index') {
		header('location: index.php');
	} else {
		header('location: todas_tarefas.php');
	}
} else if ($acao == 'marcarRealizada') {

	$categoria = new Tarefa();
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	$tarefaService->marcarRealizada();

	if (isset($_GET['pag']) && $_GET['pag'] == 'index') {
		header('location: index.php');
	} else {
		header('location: todas_tarefas.php');
	}
} else if ($acao == 'recuperarTarefasPendentes') {
	$categoria = new Tarefa();
	$tarefa = new Tarefa();
	$tarefa->__set('id_status', 1);
	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	$tarefas = $tarefaService->recuperarTarefasPendentes();
} else if ($acao == 'data_criacao_recente') {
	$categoria = new Tarefa();
	$tarefa = new Tarefa();
	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa, $categoria);
	$tarefas = $tarefaService->ordenarPorDataCadastro();
	echo json_encode($tarefas);
}
