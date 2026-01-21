<?php
/**
 * Layer: Model
 * Purpose: Database logic and data handling
 * Rules: No HTTP or view rendering logic; DB logic only
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class UserModel {
    private PDO $db;

    public function __construct(array $config){
        $this->db = Database::connect($config['db']);
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO users (first_name, last_name, wvsu_email, password, phone_number) 
                VALUES (:first, :last, :email, :password, :phone)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'first'    => $data['first_name'],
            'last'     => $data['last_name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'phone'    => $data['phone_number'] ?? '' 
        ]);
    }
}
