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

    private function logaUsuario(object $usuario){

        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario->id);
    }
}



