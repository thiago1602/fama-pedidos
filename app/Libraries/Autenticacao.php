<?php

/*
 * descricao essa biblioteca cuidara da parte de aut
 */

class Autenticacao{
    private $usuario;

    public function login(string $email, string $password){

        $usuarioModel = new App\Models\UsuarioModel();

        $usuario = $usuarioModel->BuscaUsuarioPorEmail($email);

        /*
         * se n encontar o email, retorna false
         */
        if($usuario === null){
            return false;
        }

        /*
         * se a senha n combinar com o hash, retorna false
         */
if (!$usuario->verificaPassword($password)){
    return false;
}

    /*
     * Só permir o login de usuarios ativos
     */
        if (!$usuario->ativo){
            return false;

        }
/*
 * usuario logado
 */
    $this->logaUsuario($usuario);

    return true;
    }

    public function logout(){
        session()->destroy();
    }


    public function pegaUsuarioLogado(){

        if ($this->usuario === null){

            $this->usuario = $this->pegaUsuarioDaSessao();

        }

        return $this->usuario;

    }

    public function estaLogado(){
        return $this->pegaUsuarioLogado() !== null;
    }

    private function pegaUsuarioDaSessao(){
        if (!session()->has('usuario_id')){

            return null;

        }


        $usuarioModel = new App\Models\UsuarioModel();
        $usuario = $usuarioModel->find(session()->get('usuario_id'));

        if ($usuario && $usuario->ativo){

            return $usuario;
        }
    }



    private function logaUsuario(object $usuario){

        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario->id);
    }
}



