<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateElectronicToyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'toy_id'       => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'battery_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'voltage'      => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('toy_id', 'Toys', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ElectronicToys');
    }

    public function down()
    {
        $this->forge->dropTable('ElectronicToys');
    }
}