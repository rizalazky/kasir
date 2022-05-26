<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
    public function up()
    {
            $this->forge->addField([
                'id'          => [
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true
                ],
                'category_name'      => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'default'        => '',
                ]
            ]);

            // Membuat primary key
            $this->forge->addKey('id', TRUE);

            $this->forge->createTable('categories', TRUE);
        }

        public function down()
        {
            //
            $this->forge->dropTable('categories');
        }
}
