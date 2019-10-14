<?php

//@author sydhnney


function checarSessao() {
    
    if (intval($_SESSION['idUsuario']) <= 0) {
        Redirect('../../login.html');
    }
}


//session_start();
function Redirect($url) {
    if (headers_sent ()) {
        echo "<script type='text/javascript'>location.href='$url';</script>";
    } else {
        header("Location: $url");
    }
}

function getUrlBase() {
    return "http://localhost/previnity";
    //return "http://www.omegagestao.com.br/websearch";
    //return "http://www.previnity.com.br/websearch";
    //return "http://186.202.166.195/websearch";
    //return "http://192.99.109.63/websearch";
}

function getIdUsuario() {
    return intval($_SESSION['id_usuario']);
}

function getIdRepresentante() {
    return intval($_SESSION['id_representante']);
}

function getIdCliente() {
    return intval($_SESSION['id_cliente']);
}

function getRepresentante() {
    $repBD = new RepresentanteBD();
    $rep = $repBD->getById(getIdRepresentante());
    return $rep;
}

function getCliente() {
    $cliBD = new ClienteBD();
    $cli = $cliBD->getById(getIdCliente());
    return $cli;
}

function getRegPorPagina() {
    return 100;
}

function convValorToReal($valor, $dec=2) {
    return number_format($valor, $dec, ",", ".");
}

function convValorToDolar($valor, $dec=2) {
    if (!is_numeric($valor)) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    }
    return number_format($valor, $dec, ".", "");
}

function baseToDate($data) {
    if (strlen($data) == 10) {
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);
        $data = $dia . "/" . $mes . "/" . $ano;
        return $data;
    } else {
        return null;
    }
}




function dateToBase($data) {
    if (strlen($data) == 10) {
        $dia = substr($data, 0, 2);
        $mes = substr($data, 3, 2);
        $ano = substr($data, 6, 4);
        $data = $ano . "-" . $mes . "-" . $dia;
        return $data;
    } else {
        return null;
    }
}

function getDateNow() {
    return date("d/m/Y", mktime());
}

function getTimeNow() {
    return date("H:i:s", mktime());
    ;
}

function getDataExtenso($data) {
    $data = explode('/', $data);
    $mes_num = intval($data[1]);
    $mes = Array();
    $mes[1] = 'janeiro';
    $mes[2] = 'fevereiro';
    $mes[3] = 'mar�o';
    $mes[4] = 'abril';
    $mes[5] = 'maio';
    $mes[6] = 'junho';
    $mes[7] = 'julho';
    $mes[8] = 'agosto';
    $mes[9] = 'setembro';
    $mes[10] = 'outubro';
    $mes[11] = 'novembro';
    $mes[12] = 'dezembro';
    $mes_extenso = ucfirst($mes[$mes_num]);
    return "$data[0] de $mes_extenso de $data[2]";
}

//acrescentar dias a uma data
function incDate($data, $inc) {
    $dt = explode("/", $data);
    $inc = intval($inc);
    $dia = $dt[0] + $inc;
    $mes = $dt[1];
    $ano = $dt[2];
    return date("d/m/Y", mktime(0, 0, 0, $mes, $dia, $ano));
}

//retorna limite de regitros que poderao ser exibidos no SQL
function getLimitSQL($pagina) {
    $pagina = intval($pagina);
    $quantidade_por_pagina = getRegPorPagina();
    if ($pagina == 1) {
        $inicio = 0;
    } else {
        $inicio = $pagina * $quantidade_por_pagina - $quantidade_por_pagina + 1;
    }
    $final = $quantidade_por_pagina;
    $texto = " LIMIT $inicio, $final";
    return $texto;
}

//retorna limite de regitros que poderao ser exibidos no SQL
function getLimitSQL_FB($pagina) {
    $pagina = intval($pagina);
    $quantidade_por_pagina = getRegPorPagina();
    if ($pagina == 1) {
        $inicio = 0;
    } else {
        $inicio = $pagina * $quantidade_por_pagina - $quantidade_por_pagina + 1;
    }
    $final = $quantidade_por_pagina;
    $texto = " FIRST $final SKIP $inicio ";
    return $texto;
}

function getUF() {
    $estado['AC'] = 'AC';
    $estado['AL'] = 'AL';
    $estado['AP'] = 'AP';
    $estado['AM'] = 'AM';
    $estado['BA'] = 'BA';
    $estado['CE'] = 'CE';
    $estado['ES'] = 'ES';
    $estado['GO'] = 'GO';
    $estado['MA'] = 'MA';
    $estado['MT'] = 'MT';
    $estado['MS'] = 'MS';
    $estado['MG'] = 'MG';
    $estado['PA'] = 'PA';
    $estado['PB'] = 'PB';
    $estado['PR'] = 'PR';
    $estado['PE'] = 'PE';
    $estado['PI'] = 'PI';
    $estado['RJ'] = 'RJ';
    $estado['RN'] = 'RN';
    $estado['RS'] = 'RS';
    $estado['RO'] = 'RO';
    $estado['SC'] = 'SC';
    $estado['SP'] = 'SP';
    $estado['SE'] = 'SE';
    $estado['TO'] = 'TO';
    $estado['DF'] = 'DF';
    return $estado;
}

function carregarUF($tpl, $bloco) {
    $uf = getUF();
    foreach ($uf as $valor) {
        $tpl->nome_estado = $valor;
        $tpl->block($bloco);
    }
}

function carregarSelect($tpl, $bloco, $array, $tpl_valor, $tpl_nome) {
    foreach ($array as $valor => $nome) {
        $tpl->$tpl_nome = $nome;
        $tpl->$tpl_valor = $valor;
        $tpl->block($bloco);
    }
}

function setParametros($request, $classe) {
    foreach ($request as $atributo => $valor) {
        $classe->$atributo = $valor;
    }
}

function preencherZeroEsquerda($valor, $tamanho) {
    return str_pad($valor, $tamanho, '0', STR_PAD_LEFT);
}

function nomearCamposHTML($tpl, $classe) {
    foreach ($classe->getIdCamposHTML() as $nome_tpl => $valor_tpl) {
        $tpl->$nome_tpl = $valor_tpl;
    }
}

//http request = 200 entao retorna true
function isURL($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($http_code == 200) {
        return true;
    } else {
        return false;
    }
}

function isAdm() {

    if ($_SESSION['tipo_login'] == 'ADM') {
        return true;
    } else {
        return false;
    }
}

function isPainel() {
    if ($_SESSION['tipo_login'] == 'PAINEL') {
        return true;
    } else {
        return false;
    }
}

function isValida() {
    if ($_SESSION['tipo_login'] == 'VALIDA') {
        return true;
    } else {
        return false;
    }
}

function isCartao() {
    if ($_SESSION['tipo_login'] == 'CARTAO') {
        return true;
    } else {
        return false;
    }
}

function isConfig() {
    if ($_SESSION['tipo_login'] == 'CFG') {
        return true;
    } else {
        return false;
    }
}

function isConsulta() {
    if ($_SESSION['tipo_login'] == 'CONSULTA') {
        return true;
    } else {
        return false;
    }
}

function showBotoes($tpl, $mostrar) {
    if ($mostrar) {
        $tpl->mostrar_btn = "style='display:normal'";
    } else {
        $tpl->mostrar_btn = "style='display:none'";
    }
}

function formataCPFCNPJ($num) {
    $num = trim($num);
    $num = str_replace('.', '', $num);
    $num = str_replace('-', '', $num);
    $num = str_replace('/', '', $num);
    if (strlen($num) <= 11) {  //cpf
        $num = str_pad($num, 11, '0', STR_PAD_LEFT);
    } else { //cnpj
        $num = str_pad($num, 14, '0', STR_PAD_LEFT);
    }
    return $num;
}

//formato dd/mm/aaaa
function calculoIdade($data) {
 
    //Data atual
    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');
 
    //Data do anivers�rio
    $nascimento = explode('/', $data);
    $dianasc = ($nascimento[0]);
    $mesnasc = ($nascimento[1]);
    $anonasc = ($nascimento[2]);
 
    // se for formato do banco, use esse c�digo em vez do de cima!
    /*
    $nascimento = explode('-', $nascimento);
    $dianasc = ($nascimento[2]);
    $mesnasc = ($nascimento[1]);
    $anonasc = ($nascimento[0]);
     */
 
    //Calculando sua idade
    $idade = $ano - $anonasc; // simples, ano- nascimento!
 
    if ($mes < $mesnasc) // se o mes � menor, s� subtrair da idade
    {
        $idade--;
        return $idade;
    }
    elseif ($mes == $mesnasc && $dia <= $dianasc) // se esta no mes do aniversario mas n�o passou ou chegou a data, subtrai da idade
    {
        $idade--;
        return $idade;
    }
    else // ja fez aniversario no ano, tudo certo!
    {
        return $idade;
    }
}

function criptografar($texto){
    $criptogrado = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, CHAVE, $texto, MCRYPT_MODE_ECB);
    return bin2hex($criptogrado);
}
?>
