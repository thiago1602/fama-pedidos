<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Usuario;

class Usuarios extends BaseController
{

    private $usuarioModel;

    public function __construct(){
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }
    public function index()
    {

        $data = [
            'titulo' => 'Listando os usúarios',
             'usuarios' => $this->usuarioModel->withDeleted(true)->paginate(2),
            'pager'=> $this->usuarioModel->pager,
        ];

session()->remove('sucesso');

        return view('Admin/Usuarios/index', $data);
    }


    public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Página não encontrada');
        }

        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));

        $retorno = [];


        foreach ($usuarios as $usuario){
            $data['id'] = $usuario->id;
            $data['value'] = $usuario->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function criar (){

        $usuario = new Usuario();



        $data = [
            'titulo'=>"Criando novo usuário",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/criar', $data);

    }

    public function cadastrar(){

        if ($this->request->getMethod() === 'post'){


            $usuario = new Usuario($this->request->getPost());


            if ($this->usuarioModel->protect(false)->save($usuario)){

                return redirect()->to(site_url("admin/usuarios/show/".$this->usuarioModel->getInsertID()))
                    ->with('sucesso', "Usuário $usuario->nome cadastrado com sucesso.");

            }else{

                return redirect()->back()
                    ->with('errors_model', $this->usuarioModel->errors())
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



    public function show ($id = null){


        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo'=>"Detalhando o usuário $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/show', $data);

    }
    public function editar($id = null){


        $usuario = $this->buscaUsuarioOu404($id);

        if ($usuario->deletado_em != null){

            return redirect()->back()->with('info', "O usuário $usuario->nome encontra-se excluido. Não é possivel editar-lo");

        }

        $data = [
            'titulo'=>"Editando o usuário $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/editar', $data);

    }


    public function atualizar($id = null){

        if ($this->request->getMethod() === 'post'){
            $usuario = $this->buscaUsuarioOu404($id);

            if ($usuario->deletado_em != null){

                return redirect()->back()->with('info', "O usuário $usuario->nome encontra-se excluido. Não é possivel editar-lo");

            }


            $post = $this->request->getPost();

            if(empty($post['password'])){

                $this->usuarioModel->desabilitaValidacaoSenha();
                unset($post['password']);
                unset($post['password_confirmation']);


            }

            $usuario->fill($post);


            if (!$usuario->hasChanged()){

                return redirect()->back()->with('info', 'Não a dados para atualizar');
            }



            if ($this->usuarioModel->protect(false)->save($usuario)){

                return redirect()->to(site_url("admin/usuarios/show/$usuario->id"))
                    ->with('sucesso', "Usuário $usuario->nome atualizado com sucesso.");

            }else{

                return redirect()->back()
                    ->with('errors_model', $this->usuarioModel->errors())
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


        $usuario = $this->buscaUsuarioOu404($id);

        if ($usuario->deletado_em != null){

            return redirect()->back()->with('info', "O usuário $usuario->nome já encontra-se excluido.");

        }


        if ($usuario->is_admin){
            return redirect()->back()->with('info', 'Não épossivel excluir um usuário <b>Administrador</b>');
        }

        if($this->request->getMethod() === 'post' ){
            $this->usuarioModel->delete($id);
            return redirect()->to(site_url('admin/usuarios'))->with('sucesso', "Usuário $usuario->nome excluido com sucesso");
        }

        $data = [
            'titulo'=>"Excluindo o usuário $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/excluir', $data);

    }

    public function desfaserExclusao($id = null){


        $usuario = $this->buscaUsuarioOu404($id);

        if ($usuario->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas usuários excluidos podem ser recuperados');
        }

        if ($this->usuarioModel->desfaserExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso');


        }else{
            return redirect()->back()
                ->with('errors_model', $this->usuarioModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }




    /**
     * @param int $id
     * @return object usuario
     */
    private function buscaUsuarioOu404(int $id = null){

        if(!$id || !$usuario = $this->usuarioModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuario $id");
        }

        return $usuario;
    }
}
