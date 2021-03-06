<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends Model
{
    protected $table                = 'entregadores';
    protected $returnType           = 'App\Entities\Entregador';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'nome',
        'ativo',

    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'criado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    //Validacoes
    protected $validationRules    = [
        'nome'     => 'required|min_length[4]|max_length[120]',

    ];

    protected $validationMessages = [
        'nome'        => [
            'required' => 'O campo nome é obrigatório.',
        ],


    ];

    public function procurar($term)
    {
        if($term === null){
            return [];
        }

        return $this->select('id, nome')
            ->like('nome', $term)
            ->withDeleted(true)
            ->get()
            ->getResult();
    }

    public function desfaserExclusao(int $id )
    {

        return $this->protect(false)
            ->where('id', $id)
            ->set('deletado_em', null)
            ->update();
    }

    public function recuperaTotalEntregadoresAtivos() {

        return $this->where('ativo', true)
            ->countAllResults();
    }

    public function recuperaEntregadoresMaisAssiduos(int $quantidade) {


        return $this->select('entregadores.nome, COUNT(*) as entregas')
            ->join('pedidos', 'pedidos.entregador_id = entregadores.id')
            ->where('pedidos.situacao', 2) // pedidos entregues
            ->limit($quantidade)
            ->groupBy('entregadores.nome')
            ->orderBy('entregas', 'DESC')
            ->find();
    }


}
