<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        // Membuat kolom/field untuk tabel products
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'     => false,
			],
			'password'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'        => false,
			],
			'name'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'default'        => '',
			],
			'adress'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 150,
				'default'        => '',
			]
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		$this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('users');
    }
}
