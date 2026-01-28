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
        $sql = "INSERT INTO users (first_name, last_name, wvsu_email, password, phone_number, email_verified, verification_code, verification_expiry) 
                VALUES (:first, :last, :email, :password, :phone, 0, :v_code, :v_expiry)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'first'    => $data['first_name'],
            'last'     => $data['last_name'],
            'email'    => $data['email'],
            'password' => $data['hashedPass'],
            'phone'    => $data['phone_number'] ?? '',
            'v_code' => $data['v_code_hashed'],
            'v_expiry' => $data['v_code_expiry']
        ]);
    }

    function findByEmail(string $email): ?array{
        // Query the database and return the row of that email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE wvsu_email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

}
