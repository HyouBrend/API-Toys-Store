<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PlasticToys extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'toy_id'      => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'plastic_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'is_bpa_free' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at'  => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('toy_id', 'Toys', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('PlasticToys');
    }

    public function down()
    {
        $this->forge->dropTable('PlasticToys');
    }
}