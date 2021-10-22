<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelExpediente extends Model
{
    protected $table                = 'expediente';
    protected $returnType           = 'object';
    protected $allowedFields        = ['abertura', 'fechamento', 'situacao'];


    // Validation
    protected $validationRules    = [
        'abertura'     => 'required',
        'fechamento'     => 'required',


    ];

    protected $validationMessages = [
        'abertura'        => [
            'required' => 'O campo nome é obrigatório.',
            'is_unique' => 'Esse bairro ja existe',

        ],

    ];

}
