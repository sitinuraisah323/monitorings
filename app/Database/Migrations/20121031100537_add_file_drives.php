<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileDrives extends Migration
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
                        'filename'       => [
                                'type'       => 'TEXT',
                        ],
                        'path'       => [
                            'type'       => 'TEXT',
                         ],
                        'extention' => [
                                'type' => 'VARCHAR',
                                'null' => true,
                        ],
                ]);
                $this->forge->addKey('id', true);
                $this->forge->createTable('file_drives');
        }

        public function down()
        {
                $this->forge->dropTable('blog');
        }
}