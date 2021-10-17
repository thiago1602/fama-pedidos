<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoEspecificacaoModel extends Model
{
    protected $table                = 'produtos_especificacoes';
    protected $returnType           = 'object';
    protected $allowedFields        = ['produto_id', 'preco', 'customizavel'];

    protected $validationRules =[
        'preco' =>'required|greater_than[0]',
    ];

    public function buscaEspecificacoesDoProduto(int $produto_id, int $quantidade_paginacao)
    {
        return $this->select('produtos_especificacoes.*')
            ->join('produtos', 'produtos.id = produtos_especificacoes.produto_id')
            ->where('produtos_especificacoes.produto_id', $produto_id)
            ->paginate($quantidade_paginacao);

    }

}
