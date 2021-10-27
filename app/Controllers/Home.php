<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;

class Home extends BaseController
{

    private $categoriaModel;
    private $produtoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
    }
    public function index()
    {

        $data = [
          'titulo' => 'Seja muito bem vindo(a)',
            'categorias'=>$this->categoriaModel->BuscaCategoriasWebHome(),
            'produtos'=>$this->produtoModel->BuscaProdutosWebHome(),
        ];
        return view('Home/index', $data);
    }

}
