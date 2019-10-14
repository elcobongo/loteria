<?php
 namespace Dto;

 use Illuminate\Database\Eloquent\Model;

 class Jogo  extends Model{

    protected $table = 'jogo';

    //representa cada coluna da tabela JOGO
    protected $fillable  = [
        'id',
        'id_usuario',
        'modalidade',
        'num1',
        'num2',
        'num3',
        'num4',
        'num5',

        'num6',
        'num7',
        'num8',
        'num9',
        'num10',

        'num11',
        'num12',
        'num13',
        'num14',
        'num15',

        'num16',
        'num17',
        'num18'
    ];

 }