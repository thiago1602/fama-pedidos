<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\FormaPagamento;
use App\Models\FormaPagamentoModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;

class FormasPagamento extends BaseController{

private $formaPagamentoModel;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();


    }

    public function index()
    {
       $data = [
           'titulo'=>'Listando as formas de pagamento',
           'formas' =>$this->formaPagamentoModel->withDeleted(true)->paginate(10),
           'pager'=>  $this->formaPagamentoModel->pager,
       ];

       return view('Admin/FormasPagamento/index', $data);
    }

    public function show($id = null)
    {
        $formaPagmento = $this->buscaFormaPagamentoOu404($id);

        $data = [
          'titulo' =>"Detalhando a forma de pagamento $formaPagmento->nome",
          'forma'=> $formaPagmento,
        ];

        return view('Admin/FormasPagamento/show', $data);

    }
    public function criar (){

        $formaPagamento = new FormaPagamento();



        $data = [
            'titulo'=>"Criando uma nova forma de pagamento",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/criar', $data);

    }


    public function cadastrar()
    {

        if ($this->request->getMethod() === 'post') {


            $formaPagamento = new FormaPagamento($this->request->getPost());


            if ($this->formaPagamentoModel->protect(false)->save($formaPagamento)) {

                return redirect()->to(site_url("admin/formas/show/" . $this->formaPagamentoModel->getInsertID()))
                    ->with('sucesso', "Forma de pagamento $formaPagamento->nome cadastrada com sucesso.");

            } else {

                return redirect()->back()
                    ->with('errors_model', $this->formaPagamentoModel->errors())
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


    public function editar($id = null)
    {
        $formaPagmento = $this->buscaFormaPagamentoOu404($id);

        $data = [
          'titulo' =>"Editando a forma de pagamento $formaPagmento->nome",
          'forma'=> $formaPagmento,
        ];

        return view('Admin/FormasPagamento/editar', $data);

    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() ==='post'){
            $formaPagmento = $this->buscaFormaPagamentoOu404($id);

            $formaPagmento->fill($this->request->getPost());

            if (!$formaPagmento->hasChanged()){
                return redirect()->back()->with('info', 'Não há dados para atualizar');

            }

            if ($this->formaPagamentoModel->save($formaPagmento))
            {
                return redirect()->to(site_url("admin/formas/show/$id"))->with('sucesso', 'Forma de pagamento atualizado com sucesso');
            }else{
                /*
                 * erros de validação
                 */
                return redirect()->back()
                    ->with('errors_model', $this->formaPagamentoModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();
            }

        }else{

            return redirect()->back();

        }


    }

    public function excluir($id = null){


        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        if ($formaPagamento->deletado_em != null){

            return redirect()->back()->with('info', "A forma de pagamento $formaPagamento->nome já encontra-se excluida.");

        }

        if($this->request->getMethod() === 'post' ){
            $this->formaPagamentoModel->delete($id);
            return redirect()->to(site_url('admin/formas'))->with('sucesso', "Forma de pagamento $formaPagamento->nome excluida com sucesso");
        }

        $data = [
            'titulo'=>"Excluindo a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/excluir', $data);

    }

    public function desfaserExclusao($id = null){


        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        if ($formaPagamento->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas formas de pagamento excluidos podem ser recuperados');
        }

        if ($this->formaPagamentoModel->desfaserExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso');


        }else{
            return redirect()->back()
                ->with('errors_model', $this->formaPagamentoModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    private function buscaFormaPagamentoOu404(int $id = null){
        if (!$id || !$formaPagamento = $this->formaPagamentoModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento $id");

    }
        return $formaPagamento;
    }
}
