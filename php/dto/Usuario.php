<?php
 namespace Dto;

 use Illuminate\Database\Eloquent\Model;

 class Usuario  extends Model{

    protected $table = 'usuario';

    //representa cada coluna da tabela USUARIO
    protected $fillable  = [
        'id',
        'nome',
        'sobrenome',
        'email',
        'tel',
        'senha'
    ];
 }