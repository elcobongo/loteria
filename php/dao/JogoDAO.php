<?php
use Illuminate\Database\Capsule\Manager as DB;
use Dto\Jogo;

class JogoDAO{
    public function getJogo($id){
        //$result = DB::Table('jogo')->find($id);
        $jogo = Dto\Jogo::find($id);
        return $jogo;
    }

    public function gravar(Jogo $jogo){
        if ($jogo->id == 0) {
            return $jogo->save();
        } else {
            //$registro = $this->recuperarJogoPorUsuairoModalidade(intval($dados["id_usuario"]), intval($dados["modalidade"]));
            $registro = $this->getJogo($jogo->id);
            $registro->num1 = $jogo->num1;
            $registro->num2 = $jogo->num2;
            $registro->num3 = $jogo->num3;
            $registro->num4 = $jogo->num4;
            $registro->num5 = $jogo->num5;

            $registro->num6 = $jogo->num6;
            $registro->num7 = $jogo->num7;
            $registro->num8 = $jogo->num8;
            $registro->num9 = $jogo->num9;
            $registro->num10 = $jogo->num10;

            $registro->num11 = $jogo->num11;
            $registro->num12 = $jogo->num12;
            $registro->num13 = $jogo->num13;
            $registro->num14 = $jogo->num14;
            $registro->num15 = $jogo->num15;

            $registro->num16 = $jogo->num16;
            $registro->num17 = $jogo->num17;
            $registro->num18 = $jogo->num18;

            return $registro->save();
        }
    }

    public function recuperarJogoPorUsuairoModalidade($id_usuario, $modalidade){
        return DTO\Jogo::where('id_usuario', $id_usuario)->where('modalidade', $modalidade)->get();
    }

    public function excluir($id, $id_usuario){

        $jogo = DTO\Jogo::where("id",$id)->where('id_usuario', $id_usuario)->first();
        if ($jogo != null){
            $jogo->delete();
        }
    }

    public function excluirJogosPorUsuario($id_usuario){
        $jogo = DTO\Jogo::where('id_usuario', $id_usuario)->delete();
        return 1;
    }

    public function existeDuplicidadeJogo($id_usuario, $modalidade, $str_numeros, $id){
        $sql = "select 1 from jogo ";
        $sql .= " where id_usuario = $id_usuario and modalidade = $modalidade and id <> $id ";
        $sql .= " and  json_array(num1, num2, num3, num4, num5, num6, num7, num8, num9, num10, num11, num12, num13, num14, num15, num16, num17, num18) = json_array($str_numeros)";

        $result =  DB::select($sql);
        $qtd = count($result);

        if ($qtd > 0){
            return true;
        } else {
            return false;
        }
    }


}
