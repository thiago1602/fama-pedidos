<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaEntregadores extends Migration {

    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type' => 'INT',
                'constraint'=>5,
                'unsigned' => true,
                'auto_increment' => true,
            ] ,
            'nome'=>[
                'type'=>'VARCHAR',
                'constraint'=>'128',
            ],


            'ativo'=>[
                'type'=>'BOOLEAN',
                'null'=>false,
                'default'=>true,
            ],

            'criado_em'=>[
                'type'=>'DATETIME',
                'null'=>true,
                'default'=>null,
            ],
            'atualizado_em'=>[
                'type'=>'DATETIME',
                'null'=>true,
                'default'=>null,
            ],
            'deletado_em'=>[
                'type'=>'DATETIME',
                'null'=>true,
                'default'=>null,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('entregadores');
    }

    public function down()
    {
        $this->forge->dropTable('entregadores');
    }

}
