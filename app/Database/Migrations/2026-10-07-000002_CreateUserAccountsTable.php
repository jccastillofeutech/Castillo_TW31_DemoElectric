<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAccountsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('user_accounts', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('user_accounts', true);
    }
}
