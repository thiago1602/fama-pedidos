<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {

    public function run() {

        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Thiago de Moraes Fonseca',
            'email' => 'admin@admin.com',
            'password' => '123456',
            'cpf' => '422.768.228-21',
            'telefone' => '14 - 9999-9999',
            'is_admin' => true,
            'ativo' => true,
        ];

        $usuarioModel->skipValidation(true)->protect(false)->insert($usuario);
    }

}
