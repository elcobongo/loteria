<?php
use Dto\Jogo;
//header('Content-Type: application/json');

session_start();

include '../globais.php';
checarSessao();
$id_usuario = intval($_SESSION["idUsuario"]);
$acao = $_REQUEST['acao'];
$id = intval($_REQUEST['id']);


$jogoDAO = new JogoDAO();


if ($acao == 'registrar_jogo'){
    

    /*$jogos =  ($_REQUEST['memoJogos']);
    $jogosArray = explode("\r\n", $jogos);

    $qtdJogos = count($jogosArray);

    foreach ($jogosArray as $jogo) {
        //caso tenha tab
        $jogo = str_replace("\t", " ", $jogo);
        //caso tenha virgula
        $jogo = str_replace(",", " ", $jogo);
        $numeros = explode(" ", $jogo);
        $qtdNumeros = count($numeros);
    }*/
    
    if ($_REQUEST['modalidade'] == 'lotofacil'){
        $dados["modalidade"] = 1;
    }

    $dados['id'] = intval(filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num1'] = intval(filter_var($_REQUEST['num1'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num2'] = intval(filter_var($_REQUEST['num2'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num3'] = intval(filter_var($_REQUEST['num3'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num4'] =   intval(filter_var($_REQUEST['num4'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num5'] = intval(filter_var($_REQUEST['num5'], FILTER_SANITIZE_NUMBER_INT));
    
    $dados['num6'] = intval(filter_var($_REQUEST['num6'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num7'] = intval(filter_var($_REQUEST['num7'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num8'] = intval(filter_var($_REQUEST['num8'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num9'] = intval(filter_var($_REQUEST['num9'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num10'] = intval(filter_var($_REQUEST['num10'], FILTER_SANITIZE_NUMBER_INT));
    
    $dados['num11'] = intval(filter_var($_REQUEST['num11'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num12'] = intval(filter_var($_REQUEST['num12'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num13'] = intval(filter_var($_REQUEST['num13'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num14'] = intval(filter_var($_REQUEST['num14'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num15'] = intval(filter_var($_REQUEST['num15'], FILTER_SANITIZE_NUMBER_INT));
    
    $dados['num16'] = intval(filter_var($_REQUEST['num16'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num17'] = intval(filter_var($_REQUEST['num17'], FILTER_SANITIZE_NUMBER_INT));
    $dados['num18'] = intval(filter_var($_REQUEST['num18'], FILTER_SANITIZE_NUMBER_INT)); 
    $dados["id_usuario"] = $id_usuario;

    //pega um pedaço do array - da posicao 1 a 18
    $numeros = (array_slice($dados,2,18));

    //ordenar array pelo valor
    sort($numeros);



    //teste numero zero
    $$qtZero = 0;
    foreach ($numeros as $valor){
        if (intval($valor) == 0) {
            $qtZero++;
         }
    }
    
    if ($qtZero > 3){
        $retorno["codRetorno"] = 2;
        $retorno["txMotivo"] = "A aposta deve contar pelo menos 15 números válidos";
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
        return;
    }

    

    
   
    //junta elementos de uma matriz em uma string com separador
    $str_numeros = implode(',',$numeros);
    //testa duplicidade de volante na base
    $duplicidade = $jogoDAO->existeDuplicidadeJogo(intval($dados["id_usuario"]), intval($dados["modalidade"]), $str_numeros, $id);
    if ($duplicidade){   
        $retorno["codRetorno"] = 2;
        $retorno["txMotivo"] = "Existe um volante registrado com os mesmos números";
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
        return;
    }

        //testa números negativos e maior que 25
        foreach ($numeros as $valor){
            if ( intval($valor) <= -1 || intval($valor) > 25){
                $retorno["codRetorno"] = 2;
                $retorno["txMotivo"] = "Não pode existir número inferior que 1 e maior que 25";
                echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
                return;
            }
        }

    //teste número duplicado dentro do mesmo volante
    //pega as chaves dos array de todos os itens que contem zero (0)
    $numeros_sem_zero = $numeros;
    foreach (array_keys($numeros_sem_zero, '0') as $key) {
        unset($numeros_sem_zero[$key]);
    }

    $array_unico = array_unique($numeros);
    foreach (array_keys($array_unico, '0') as $key) {
        unset($array_unico[$key]);
    }

    if (count($numeros_sem_zero) != count($array_unico)){
        $retorno["codRetorno"] = 2;
        $retorno["txMotivo"] = "Volante com número duplicado.";
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
        return;
    }

    $jogo = new Jogo();
    $jogo->id = $dados["id"];
    $jogo->modalidade = $dados["modalidade"];
    $jogo->id_usuario = $id_usuario;
    $jogo->num1 = $numeros[0];
    $jogo->num2 = $numeros[1];
    $jogo->num3 = $numeros[2];
    $jogo->num4 = $numeros[3];
    $jogo->num5 = $numeros[4];

    $jogo->num6 = $numeros[5];
    $jogo->num7 = $numeros[6];
    $jogo->num8 = $numeros[7];
    $jogo->num9 = $numeros[8];
    $jogo->num10 = $numeros[9];

    $jogo->num11 = $numeros[10];
    $jogo->num12 = $numeros[11];
    $jogo->num13 = $numeros[12];
    $jogo->num14 = $numeros[13];
    $jogo->num15 = $numeros[14];

    $jogo->num16 = $numeros[15];
    $jogo->num17 = $numeros[16];
    $jogo->num18 = $numeros[17];

    
    $result = $jogoDAO->gravar($jogo);
    if ($result == 1){
        $retorno["codRetorno"] = 1;
            $retorno["txMotivo"] = "Jogo registrado com sucesso";
            echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
    }

} else if ($acao == 'recuperar'){
    if ($_REQUEST['modalidade'] == 'lotofacil'){
        $modalidade = 1;
    }
    $retorno = $jogoDAO->recuperarJogoPorUsuairoModalidade($id_usuario, $modalidade);
    $retorno = json_decode($retorno, true);
    $i=0;
    foreach ($retorno as $v){
        $saida[$i][0] = $v['id'];

        $numeros = (array_slice($v,4,18));
        $numeros_sem_zero = $numeros;
        foreach (array_keys($numeros_sem_zero, '0') as $key) {
            unset($numeros_sem_zero[$key]);
        }
        $str_numeros = implode(' - ', $numeros_sem_zero);
        $saida[$i][1] =  $str_numeros;
        $i++;
    }
    echo json_encode($saida);



} else if ($acao == 'excluir'){
    
     $result = $jogoDAO->excluir($id, $id_usuario);


}