<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Myth\Auth\Password;

class AddSuperadmin extends Migration
{
    public function up()
    {
        // Check if column exists before adding
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('users');
        $columnExists = false;

        foreach ($fields as $field) {
            if ($field->name === 'is_superadmin') {
                $columnExists = true;
                break;
            }
        }

        if (!$columnExists) {
            $this->forge->addColumn('users', [
                'is_superadmin' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'null' => false,
                    'default' => 0,
                    'after' => 'username'
                ]
            ]);
        }

        // INSERT INITIAL SUPERADMIN
        $email = 'adminsuper@gmail.com';
        $username = 'superadmin';
        $password = 'superadmin';

        $encryptedPassword = Password::hash($password);

        $this->forge->getConnection()->query(
            "INSERT IGNORE INTO users (email, username, is_superadmin, password_hash, active) 
            VALUES ('$email', '$username', 1, '$encryptedPassword', 1)"
        );
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'is_superadmin');
    }
}
