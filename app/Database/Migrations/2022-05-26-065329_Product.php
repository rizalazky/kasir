<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
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
			'category_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],
			'product_name'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'        	 => false,
				'unique'		 => true
			],
			'product_image'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'default'        => '',
			],
			'product_desc' => [
				'type'           => 'TEXT',
				'null'           => true,
			],
			'product_price'      => [
				'type'           => 'DOUBLE',
				'default'        => 0,
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		$this->forge->createTable('products', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('products');
    }
}
