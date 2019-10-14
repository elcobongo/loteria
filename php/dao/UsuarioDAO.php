<?php
use Illuminate\Database\Capsule\Manager as DB;
use Dto\Usuario;

class UsuarioDAO{
    public function getUsuario($idUsuario){
        //$result = DB::Table('usuario')->find($idUsuario);
        $result = DTO\Usuario::find($idUsuario);
        return $result;
    }

    public function gravar(Array $dados){
        if (!$this->existe($dados)){
            $usuario = new Usuario($dados);
            return $usuario->save();
        } else {
            return 2; //duplicidade
        }
    }

    public function recuperarUsuPeloEmail(Array $dados){
        return DTO\Usuario::where('email',$dados['email'])->first();
    }

    public function login(Array $dados){
        return DTO\Usuario::where('email',$dados['email'])->where('senha',$dados['senha'])->first();
    }

    public function existe(Array $dados){
        if (DTO\Usuario::where('email',$dados['email'])->get()->count() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function excluir($id){
        DTO\Usuario::destroy($id);
        return 1;
    }
}
