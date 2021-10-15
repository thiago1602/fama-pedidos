<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use CodeIgniter\Entity\Entity;

class Produtos extends BaseController
{

    private $produtoModel;
    private $categoriaModel;

    public function __construct ()
    {
        $this->produtoModel = new ProdutoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    public function index()
    {
        $data = [
          'titulo' => 'Listando os produtos',
          'produtos' => $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                                            ->join('categorias', 'categorias.id =  produtos.categoria_id')
                                            ->withDeleted(true)
                                            ->paginate(10),
            'pager' => $this->produtoModel->pager,
        ];

        return view('Admin/Produtos/index', $data);
    }

    public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Página não encontrada');
        }

        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($produtos as $produto){
            $data['id'] = $produto->id;
            $data['value'] = $produto->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function show ($id = null){


        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'=>"Detalhando o produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/show', $data);

    }

    public function criar (){

        $produto = new Produto();



        $data = [
            'titulo'=>"Criando novo produto",
            'produto' => $produto,
            'categorias'=> $this->categoriaModel->where('ativo', true)->findAll()
        ];

        return view('Admin/Produtos/criar', $data);

    }

    public function cadastrar()
    {

        if ($this->request->getMethod() === 'post') {


            $produto = new Produto($this->request->getPost());


            if ($this->produtoModel->protect(false)->save($produto)) {

                return redirect()->to(site_url("admin/produtos/show/" . $this->produtoModel->getInsertID()))
                    ->with('sucesso', "Produto $produto->nome cadastrado com sucesso.");

            } else {

                return redirect()->back()
                    ->with('errors_model', $this->produtoModel->errors())
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
    public function editar ($id = null){


        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'=>"Editando o produto $produto->nome",
            'produto' => $produto,
            'categorias'=>$this->categoriaModel->where('ativo', true)->findAll()

        ];

        return view('Admin/Produtos/editar', $data);

    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post')
        {

            $produto = $this->buscaProdutoOu404($id);


            $produto->fill($this->request->getPost());

            if (!$produto->hasChanged())
            {
                return redirect()->back()->with('info','Não há dados para atualizar');

            }
            if ($this->produtoModel->save($produto))
            {
                return redirect()->to(site_url("admin/produtos/show/$id"))->with('sucesso', 'Produto atualizado com sucesso');
            }else{
                /*
                 * erros de validação
                 */
                return redirect()->back()
                    ->with('errors_model', $this->produtoModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();
            }
        }else{
            return redirect()->back();
        }
    }

    private function buscaProdutoOu404(int $id = null){
        if (!$id || !$produto = $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                ->join('categorias', 'categorias.id =  produtos.categoria_id')
                ->where('produtos.id', $id)
                ->withDeleted(true)
                ->first())
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o produto $id");

        }
        return $produto;
    }

}
