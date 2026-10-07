<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerAccountsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'account_number' => ['type' => 'VARCHAR', 'constraint' => 50],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'address' => ['type' => 'TEXT'],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'meter_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'connection_type' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'residential'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('account_number');
        $this->forge->addKey('customer_name');
        $this->forge->addKey('connection_type');
        $this->forge->addKey('status');
        $this->forge->createTable('customer_accounts', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('customer_accounts', true);
    }
}
