<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FormaPagamento extends Entity
{
    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];
    public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Página não encontrada');
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($formas as $forma){
            $data['id'] = $forma->id;
            $data['value'] = $forma->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

}
