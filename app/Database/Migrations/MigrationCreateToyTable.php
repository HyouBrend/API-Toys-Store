<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateToyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'type'        => [
                'type'       => 'ENUM',
                'constraint' => ['Doll', 'Electronic Toy', 'Plastic Toy'],
            ],
            'price'       => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'stock'       => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('Toys');
    }

    public function down()
    {
        $this->forge->dropTable('Toys');
    }
}