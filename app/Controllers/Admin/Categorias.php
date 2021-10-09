<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Categoria;
use App\Models\CategoriaModel;
use CodeIgniter\Entity\Entity;

class Categorias extends BaseController
{
    private $categoriaModel;

    public function __construct(){
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $data = [
          'titulo' => 'Listando as categorias',
          'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager'=>$this->categoriaModel->pager,
        ];


        return view('Admin/Categorias/index', $data);
    }

    public function criar (){

        $categoria = new Categoria();



        $data = [
            'titulo'=>"Criando nova categoria",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/criar', $data);

    }

    public function cadastrar(){

        if ($this->request->getMethod() === 'post'){


            $categoria = new Categoria($this->request->getPost());


            if ($this->categoriaModel->protect(false)->save($categoria)){

                return redirect()->to(site_url("admin/categorias/show/".$this->categoriaModel->getInsertID()))
                    ->with('sucesso', "Categoria $categoria->nome cadastrada com sucesso.");

            }else{

                return redirect()->back()
                    ->with('errors_model', $this->categoriaModel->errors())
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

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($categorias as $categoria){
            $data['id'] = $categoria->id;
            $data['value'] = $categoria->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }
    public function show ($id = null){


        $categoria = $this->buscaCategoriaOu404($id);

        $data = [
            'titulo'=>"Detalhando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);

    }

    public function editar($id = null){


        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em != null){

            return redirect()->back()->with('info', "A categoria $categoria->nome encontra-se excluido. Não é possivel editar-lo");

        }

        $data = [
            'titulo'=>"Editando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar', $data);

    }


    public function atualizar($id = null)
    {

        if ($this->request->getMethod() === 'post') {
            $categoria = $this->buscaCategoriaOu404($id);

            if ($categoria->deletado_em != null) {

                return redirect()->back()->with('info', "A categoria $categoria->nome encontra-se excluido. Não é possivel editar-lo");

            }


            $post = $this->request->getPost();


        $categoria->fill($post);


        if (!$categoria->hasChanged()) {

            return redirect()->back()->with('info', 'Não a dados para atualizar');
        }


        if ($this->categoriaModel->protect(false)->save($categoria)) {

            return redirect()->to(site_url("admin/categorias/show/$categoria->id"))
                ->with('sucesso', "Categoria $categoria->nome atualizado com sucesso.");

        } else {

            return redirect()->back()
                ->with('errors_model', $this->categoriaModel->errors())
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


        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em != null){

            return redirect()->back()->with('info', "O usuário $categoria->nome já encontra-se excluido.");

        }


        if ($categoria->is_admin){
            return redirect()->back()->with('info', 'Não épossivel excluir a categoria <b>Administrador</b>');
        }

        if($this->request->getMethod() === 'post' ){
            $this->categoriaModel->delete($id);
            return redirect()->to(site_url('admin/categorias'))->with('sucesso', "Categoria $categoria->nome excluido com sucesso");
        }

        $data = [
            'titulo'=>"Excluindo a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/excluir', $data);

    }

    public function desfaserExclusao($id = null){


        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas categorias excluidos podem ser recuperados');
        }

        if ($this->categoriaModel->desfaserExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso');


        }else{
            return redirect()->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    private function buscaCategoriaOu404(int $id = null){

        if(!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a cetegoria $id");
        }

        return $categoria;
    }

}
