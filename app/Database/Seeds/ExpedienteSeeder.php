<?php

namespace App\Database\Seeds;

use App\Models\ModelExpediente;
use CodeIgniter\Database\Seeder;

class ExpedienteSeeder extends Seeder
{
    public function run()
    {
        $expedienteModel = new ModelExpediente();

        $expedientes = [
            ['dia'=>'0',
                'dia_descricao'=>'Domingo',
                'abertura'=>'8:00:00',
                'fechamento'=>'12:50:00',
                'situacao'=>true,
                ],
            ['dia'=>'1',
                'dia_descricao'=>'Segunda',
                'abertura'=>'7:30:00',
                'fechamento'=>'19:50',
                'situacao'=>true,
                ],
            ['dia'=>'2',
                'dia_descricao'=>'Terça',
                'abertura'=>'7:30:00',
                'fechamento'=>'19:50',
                'situacao'=>true,
                ],
            ['dia'=>'3',
                'dia_descricao'=>'Quarta',
                'abertura'=>'7:30:00',
                'fechamento'=>'19:50',
                'situacao'=>true,
                ],['dia'=>'4',
                'dia_descricao'=>'Quinta',
                'abertura'=>'7:30:00',
                'fechamento'=>'19:50',
                'situacao'=>true,
                ],
            ['dia'=>'5',
                'dia_descricao'=>'Sexta',
                'abertura'=>'7:30:00',
                'fechamento'=>'19:50',
                'situacao'=>true,
                ],
            ['dia'=>'6',
                'dia_descricao'=>'Sabado',
                'abertura'=>'7:30:00',
                'fechamento'=>'17:50',
                'situacao'=>true,
                ],

        ];

        foreach ($expedientes as $expediente)
        {
            $expedienteModel->protect(false)->insert($expediente);
        }
    }
}
