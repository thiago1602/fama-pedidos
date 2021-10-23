<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelExpediente;

class Expedientes extends BaseController
{
    private $expedienteModel;

    public function __construct()
    {
        $this->expedienteModel = new ModelExpediente();

    }
    public function expedientes()
    {
        if ($this->request->getMethod() === 'post')
        {

            $postExpedientes = $this->request->getPost();

            $arrayExpedientes = [];

            for ($contador = 0; $contador < count($postExpedientes['dia_descricao']); $contador++)
            {
                array_push($postExpedientes,[
                    'dia_descricao'=>$postExpedientes['dia_descricao'][$contador],
                    'abertura'=>$postExpedientes['abertura'][$contador],
                    'fechamento'=>$postExpedientes['fechamento'][$contador],
                    'situacao'=>$postExpedientes['situacao'][$contador],
                ]);
            } //fim do for

            $this->expedienteModel->updateBatch($arrayExpedientes, 'dia_descricao');

            return redirect()->back()->with('sucesso', 'Expedientes atualizados com sucesso');
        }

        $data = [
          'titulo'=>'Gerenciar o horário de funcionamento',
          'expedientes'=>$this->expedienteModel->findAll(),
        ];

        return view('Admin/Expedientes/expedientes', $data);
    }
}
