<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateDollTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'toy_id'    => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'material'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'size'      => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('toy_id', 'Toys', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Dolls');
    }

    public function down()
    {
        $this->forge->dropTable('Dolls');
    }
}