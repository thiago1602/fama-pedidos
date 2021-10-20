<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Entregador;
use App\Models\EntregadorModel;
use CodeIgniter\Entity\Entity;

class Entregadores extends BaseController
{

    private $entregadorModel;

    public function __construct()
    {
        $this->entregadorModel = new EntregadorModel();
    }
    public function index()
    {
        $date = [
            'titulo'=>'Listando os entregadores',
            'entregadores'=>$this->entregadorModel->withDeleted(true)->paginate(10),
            'pager'=> $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $date);
    }

    public function criar (){

        $entregador = new Entregador();



        $data = [
            'titulo'=>"Criando novo entregador",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/criar', $data);

    }

    public function cadastrar(){

        if ($this->request->getMethod() === 'post'){


            $entregador = new Entregador($this->request->getPost());


            if ($this->entregadorModel->protect(false)->save($entregador)){

                return redirect()->to(site_url("admin/entregadores/show/".$this->entregadorModel->getInsertID()))
                    ->with('sucesso', "Entregador $entregador->nome cadastrado com sucesso.");

            }else{

                return redirect()->back()
                    ->with('errors_model', $this->entregadorModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();

            }



        }else{

            /**
             * n é post
             */
            return redirect()->back();
        }
    }

    public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Página não encontrada');
        }

        $entregador = $this->entregadorModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($entregadores as $entregador){
            $data['id'] = $entregador->id;
            $data['value'] = $entregador->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function show ($id = null){


        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            'titulo'=>"Detalhando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/show', $data);

    }

    public function editar($id = null){


        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em != null){

            return redirect()->back()->with('info', "O entregador $entregador->nome encontra-se excluido. Não é possivel editar-lo");

        }

        $data = [
            'titulo'=>"Editando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar', $data);

    }

    public function atualizar($id = null)
    {

        if ($this->request->getMethod() === 'post') {
            $entregador = $this->buscaEntregadorOu404($id);

            if ($entregador->deletado_em != null) {

                return redirect()->back()->with('info', "O entregador $entregador->nome encontra-se excluido. Não é possivel editar-lo");

            }

            $entregador->fill($this->request->getPost());


            if (!$entregador->hasChanged()) {

                return redirect()->back()->with('info', 'Não a dados para atualizar');
            }


            if ($this->entregadorModel->save($entregador)) {

                return redirect()->to(site_url("admin/entregadores/show/$entregador->id"))
                    ->with('sucesso', "Entregador $entregador->nome atualizado com sucesso.");

            } else {

                return redirect()->back()
                    ->with('errors_model', $this->entregadorModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();

            }


        }else{

            /**
             * n é post
             */
            return redirect()->back();
        }
    }

    public function excluir($id = null){


        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em != null){

            return redirect()->back()->with('info', "O entregador $entregador->nome já encontra-se excluido.");

        }

        if($this->request->getMethod() === 'post' ){
            $this->entregadorModel->delete($id);
            return redirect()->to(site_url('admin/entregadores'))->with('sucesso', "Entregador $entregador->nome excluido com sucesso");
        }

        $data = [
            'titulo'=>"Excluindo o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/excluir', $data);

    }

    public function desfaserExclusao($id = null){


        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas entregadores excluidos podem ser recuperados');
        }

        if ($this->entregadorModel->desfaserExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso');


        }else{
            return redirect()->back()
                ->with('errors_model', $this->entregadorModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    private function buscaEntregadorOu404(int $id = null){

        if(!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o entregador $id");
        }

        return $entregador;
    }
}
