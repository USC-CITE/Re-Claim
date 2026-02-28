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

    public function create(array $data): int {
        $sql = "INSERT INTO users (first_name, last_name, wvsu_email, password, phone_number, social_link, email_verified, verification_code, verification_expiry) 
                VALUES (:first, :last, :email, :password, :phone, :social, 0, :v_code, :v_expiry)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'first'    => $data['first_name'],
            'last'     => $data['last_name'],
            'email'    => $data['email'],
            'password' => $data['hashedPass'],
            'phone'    => $data['phone_number'] ?? '',
            'social' => $data['social_link'],
            'v_code' => $data['v_code_hashed'],
            'v_expiry' => $data['v_code_expiry']
        ]);
        
        return (int)$this->db->lastInsertId();
    }

    function findByEmail(string $email): ?array{
        // Query the database and return the row of that email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE wvsu_email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    function verifyOtp(string $email, string $otp): bool{

        // We utilized our findByEmail helper function
        $user = $this->findByEmail($email);

        // If user does not exist
        if(!$user){
            return false;
        }

        // If otp exceeds time expiration
        if($user['verification_expiry'] < date('Y-m-d H:i:s')) return false;

        // If otp sent by user does not match from the otp that we generated
        if(!password_verify($otp, $user['verification_code'])) return false;

        $stmt = $this->db->prepare("
            UPDATE users SET email_verified = 1, verification_code = NULL, verification_expiry = NULL 
            WHERE wvsu_email = :email
        ");
        return $stmt->execute(['email' => $email]);
    }

    public function updateOtp(string $email, string $hashed, string $expires): bool {
        $stmt = $this->db->prepare(
            "UPDATE users SET verification_code = :code, verification_expiry = :expiry WHERE wvsu_email = :email"
        );

        return $stmt->execute([
            'code' => $hashed,
            'expiry' => $expires,
            'email' => $email
        ]);
    }

    public function fetchItems(int $id, string $type){

        $stmt = $this->db->prepare(
            "SELECT * FROM lost_and_found_items
             WHERE user_id = :id
               AND item_type = :type
               AND status != 'Archived'
             ORDER BY created_at DESC"
        );

        $stmt->execute([
            'id' => $id,
            'type' => $type
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function fetchArchivedItems(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM lost_and_found_items
             WHERE user_id = :id
               AND status = 'Archived'
             ORDER BY created_at DESC"
        );

        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


