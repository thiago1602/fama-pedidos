<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel();

        $usuario = [
          'nome' => 'Lucio Souza',
          'email' => 'admin@admin.com',
          'cpf' => '349.957.910-35',
          'telefone' => '14 - 9999 - 9999',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
          'nome' => 'Fulano Souza',
          'email' => 'fulano@admin.com',
            'cpf' => '349.466.600-89',
            'telefone' => '14 - 8888 - 8888',

        ];

        $usuarioModel->protect(false)->insert($usuario);


        dd($usuarioModel->errors());
    }

}
