<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class UsuarioModel extends Model
{
    protected $table                = 'usuarios';
    protected $returnType           = 'App\Entities\Usuario';
    protected $allowedFields        = ['nome', 'email','telefone'];
    protected $useSoftDelete       = true;
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';
    protected $validationRules    = [
        'nome'     => 'required|min_length[4]|max_length[120]',
        'email'        => 'required|valid_email|is_unique[usuarios.email]',
        'cpf'        => 'required|exact_length[14]|is_unique[usuarios.cpf]',
        'password'     => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [
        'email'        => [
            'required' => 'Esse campo é obrigatório.',
            'is_unique' => 'Desculpe. Esse email ja existe.',
        ],
        'nome'        => [
            'required' => 'Esse campo é obrigatório.',
        ],
        'cpf'        => [
            'required' => 'Esse campo é obrigatório.',
            'is_unique' => 'Desculpe. Esse CPF ja existe.',
        ],
    ];




    /**
     * @uso Controller usuarios no mét procurar com o autocomplete
     * @param string  $term
     * @return array usuarios
     */
    public function procurar($term)
    {
        if($term === null){
            return [];
        }

        return $this->select('id, nome')
                    ->like('nome', $term)
                ->get()
                ->getResult();
    }


    public function desabilitaValidacaoSenha(){

        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }


}
