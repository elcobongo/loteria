<?php

/* Arquivo responsável para captura do resultado da loteria em site externo, no caso lotodicas.com.br  */

//inicia sessao
session_start();

//incluir arquivo necessários para execução das rotinas
include '../globais.php';

//verifca se a sessao existe, caso contrario, redireciona para pagina de login
checarSessao();
//captura ID do usuário logado (sessao)
$id_usuario = intval($_SESSION["idUsuario"]);

//captura acao vinda da URL
$acao = $_REQUEST['acao'];
$concurso = intval($_REQUEST['concurso']);

//instancia objeto JogoDAO
//$jogoDAO = new JogoDAO();

//captura resultado de loteria em site externo
if ($acao == 'conferir'){
    if ($concurso == 0) { $concurso = "";}
    $resultado = getSslPage('https://www.lotodicas.com.br/api/lotofacil/'.$concurso);
    echo $resultado;
}

//efetua pesquisa remota de resultado da loteria
function getSslPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


?>