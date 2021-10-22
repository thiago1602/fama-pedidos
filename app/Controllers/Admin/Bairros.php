<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Bairro;
use App\Models\BairroModel;
use CodeIgniter\Entity\Entity;

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
            'bairros'=>$this->bairroModel->withDeleted(true)->orderBy('nome', 'ASC')->paginate(10),
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

    public function criar ($id = null){


        $bairro = new Bairro();

        $data = [
            'titulo'=>"Cadastrando novo $bairro->nome",
            'bairro' => $bairro,
        ];

        return view('Admin/Bairros/criar', $data);

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

    public function cadastrar(){

        if ($this->request->getMethod() === 'post'){


            $bairro = new Bairro($this->request->getPost());


            $bairro->valor_entrega = str_replace("-", "", $bairro->valor_entrega);

            if ($this->bairroModel->protect(false)->save($bairro)){

                return redirect()->to(site_url("admin/bairros/show/".$this->bairroModel->getInsertID()))
                    ->with('sucesso', "Bairro $bairro->nome cadastrado com sucesso.");

            }else{

                return redirect()->back()
                    ->with('errors_model', $this->bairroModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();

            }



        }else{


            return redirect()->back();
        }
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

    public function consultaCep()
    {

        if (!$this->request->isAJAX())
        {
            return redirect()->to(site_url());
        }

        $validacao = service('validation');

        $validacao->setRule('cep', 'CEP','required|eact_lenght[9]');
        $retorno = [];

        if (! $validacao->withRequest($this->request)->run())
        {

            $retorno['erro'] = '<span class="text-danger small" >'.$validacao->getError().'</span>';

            return $this->response->setJSON($retorno);
        }

        $cep = str_replace('-', '', $this->request->getGet());

        /*
         * Carregando o helper consulta_cep
         */

        helper('consulta_cep');

        $consulta = $this->consultaCep($cep);

        if (isset($consulta->erro) && !isset($consulta->cep))
        {
            $retorno['erro'] = '<span class="text-danger small" >Cep Inválido</span>';

            return $this->response->setJSON($retorno);
        }

        $retorno['endereco'] = $consulta;

        return $this->response->setJSON($retorno);

    }

    public function desfaserExclusao($id = null){


        $bairro = $this->buscaBairroOu404($id);

        if ($bairro->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas bairros excluidos podem ser recuperados');
        }

        if ($this->bairroModel->desfaserExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso');


        }else{
            return redirect()->back()
                ->with('errors_model', $this->bairroModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    private function buscaBairroOu404(int $id = null){

        if(!$id || !$bairro = $this->bairroModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o bairro $id");
        }

        return $bairro;
    }

}
