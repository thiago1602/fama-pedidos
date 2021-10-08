<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Password extends BaseController
{

    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }
    public function esqueci()
    {
        $data = [
            'titulo' => 'Esqueci a minha senha'
        ];

        return view('Password/esqueci', $data);
    }

    public function processaEsqueci()
    {
        if ($this->request->getMethod() === 'post')
        {

            $usuario = $this->usuarioModel->buscaUsuarioPorEmail(
                $this->request->getPost('email')
            );

            if ($usuario === null || !$usuario->ativo)
            {
                return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Não encontramos uma conta válida para esse email')
                    ->withInput();
            }

            $usuario->iniciaPasswordReset();


            $this->usuarioModel->save($usuario);

            $this->enviaEmailRedefinicaoSenha($usuario);

            return redirect()->to(site_url('login'))->with('sucesso', 'E-mail de redefinição de senha enviada para sua caixa de entrada');
        }else{
            return redirect()->back();
        }
    }

    public function reset($token = null)
    {
        if ($token === null){
            return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Link inválido ou expirado');
        }


        $usuario = $this->usuarioModel->buscaUsuarioPraResetarSenha($token);

        if ($usuario != null)
        {
            $data = [
                'titulo' => 'Redefina a sua senha',
                'token' => $token,
            ];

            return view('Password/reset', $data);

        }else{
            return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Link inválido ou expirado');
        }

    }

    public function processaReset($token = null)
    {

        if ($token === null){
            return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Link inválido ou expirado');
        }


        $usuario = $this->usuarioModel->buscaUsuarioPraResetarSenha($token);

        if ($usuario != null)
        {

            $usuario->fill($this->request->getPost());

            if ($this->usuarioModel->save($usuario))
            {
                $usuario->completaPasswordReset();

                $this->usuarioModel->save($usuario);


                return redirect()->to(site_url("login"))->with('sucesso', 'Senha cadastrada com sucesso');
            }else{
                return redirect()->to(site_url("password/reset/$token"))
                    ->with('errors_model', $this->usuarioModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo')
                    ->withInput();
            }


        }else{
            return redirect()->to(site_url('password/esqueci'))->with('atencao', 'Link inválido ou expirado');
        }
        
    }

    private function enviaEmailRedefinicaoSenha(object $usuario){

        $email = service('email');

        $email->setFrom('no-replay@famapedidos.com.br', 'FamaGas');
        $email->setTo($usuario->email);

        $email->setSubject('Redefinição de Senha');

        $mensagem = view('Password/reset_email', ['token' =>$usuario->reset_token]);

        $email->setMessage($mensagem);

        $email->send();

    }
}
