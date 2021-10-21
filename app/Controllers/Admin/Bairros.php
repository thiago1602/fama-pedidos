<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BairroModel;

class Bairros extends BaseController
{

    private $bairroModel;

    public function __construct()
    {

        $this->bairroModel = new BairroModel();

    }
    public function index()
    {
        $date = [
            'titulo'=>'Listando os bairros atendidos',
            'bairros'=>$this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        return view('Admin/Bairros/index',$date);
    }

    public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Página não encontrada');
        }

        $bairros = $this->bairroModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($bairros as $bairro){
            $data['id'] = $bairro->id;
            $data['value'] = $bairro->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }
    public function show ($id = null){


        $bairro = $this->buscaBairroOu404($id);

        $data = [
            'titulo'=>"Detalhando o $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/show', $data);

    }

    public function editar($id = null){


        $bairro = $this->buscaBairroOu404($id);

        if ($bairro->deletado_em != null){

            return redirect()->back()->with('info', "O bairro $bairro->nome encontra-se excluido. Não é possivel editar-la");

        }

        $data = [
            'titulo'=>"Editando o bairro $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/editar', $data);

    }


    public function atualizar($id = null)
    {

        if ($this->request->getMethod() === 'post') {
            $bairro = $this->buscaBairroOu404($id);

            if ($bairro->deletado_em != null) {

                return redirect()->back()->with('info', "O bairro $bairro->nome encontra-se excluido. Não é possivel editar-lo");

            }

            $bairro->fill($this->request->getPost());


            if (!$bairro->hasChanged()) {

                return redirect()->back()->with('info', 'Não a dados para atualizar');
            }


            if ($this->bairroModel->save($bairro)) {

                return redirect()->to(site_url("admin/bairros/show/$bairro->id"))
                    ->with('sucesso', "Bairro $bairro->nome atualizado com sucesso.");

            } else {

                return redirect()->back()
                    ->with('errors_model', $this->bairroModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();

            }


        } else {

            /**
             * n é post
             */
            return redirect()->back();
        }
    }
        private function buscaBairroOu404(int $id = null){

        if(!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o bairro $id");
        }

        return $bairro;
    }

}
