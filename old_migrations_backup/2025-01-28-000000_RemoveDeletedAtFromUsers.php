<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDeletedAtFromUsers extends Migration
{
    public function up()
    {
        // Remove deleted_at column from users table
        $this->forge->dropColumn('users', 'deleted_at');
    }

    public function down()
    {
        // Add back deleted_at column if needed to rollback
        $this->forge->addColumn('users', [
            'deleted_at' => ['type' => 'datetime', 'null' => true, 'after' => 'updated_at']
        ]);
    }
}