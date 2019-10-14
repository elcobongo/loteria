<?php
//verifica sessao
session_start();
include '../globais.php';
//caputa dados vindo do formulario HTML
$acao = filter_var($_REQUEST['acao'], FILTER_SANITIZE_STRING);
$usu['nome'] = filter_var($_REQUEST['primeiroNome'], FILTER_SANITIZE_STRING);
$usu['sobrenome'] = filter_var($_REQUEST['ultimoNome'], FILTER_SANITIZE_STRING); 
$usu['email'] = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);  
$usu['tel'] = filter_var($_REQUEST['tel'], FILTER_SANITIZE_STRING);  
$usu['senha'] = md5(filter_var($_REQUEST['senha'], FILTER_SANITIZE_STRING));
$usuarioDAO = new UsuarioDAO();
$jogoDAO = new JogoDAO();

if ($acao == 'registrar'){   
    echo $usuarioDAO->gravar($usu);
} else if ($acao == 'atualizar'){   
    $retorno = $usuarioDAO->getUsuario($_SESSION['idUsuario']); 
    $retorno->nome = $usu["nome"];
    $retorno->sobrenome = $usu["sobrenome"];
    $retorno->email = $usu["email"];
    $retorno->tel = $usu["tel"];
    $retorno->senha = $usu["senha"];
    echo $retorno->save();
} else if ($acao == 'recuperar'){
    echo $usuarioDAO->recuperarUsuPeloEmail($usu); 
} else if ($acao == 'recuperarDados'){
        echo $usuarioDAO->getUsuario($_SESSION['idUsuario']); 
} else if ($acao == 'login'){ 
    $result = $usuarioDAO->login($usu);
    if ($result > 0){
        $retorno['cdRetorno'] = 1;
        $retorno['msgRetorno'] = "sucesso";
        $_SESSION['idUsuario'] = $result->id;
        $_SESSION['usuario'] = $result->nome;  
        echo json_encode($retorno);
    } else {
        $retorno['cdRetorno'] = 2;
        $retorno['msgRetorno'] = "Usuário não localizado";
        echo json_encode($retorno);
    }

} else if ($acao == 'recuperarUsuarioLogado'){
    echo json_encode($_SESSION);
} else if ($acao == 'excluir'){
    $jogoDAO->excluirJogosPorUsuario($_SESSION['idUsuario']);
    $usuarioDAO->excluir($_SESSION['idUsuario']);
    session_destroy();
    echo 1;

} else if ($acao == 'logoff'){
    session_destroy();
    echo 1;
} else {
    echo '{"cdRetorno":-1}';
    
}

