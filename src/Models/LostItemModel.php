<?php
/**
 * Layer: Model
 * Purpose: Handle database operations for lost items
 * Rules: No HTTP or view logic
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class LostItemModel
{
    private PDO $db;

    public function __construct(array $config)
    {
        // Follow existing pattern used in UserModel
        $this->db = Database::connect($config['db']);
    }
    
    public function create(array $data): bool
    {
        $sql = "INSERT INTO lost_items 
                (image_path, location_name, latitude, longitude, category, description, first_name, last_name, contact_details, user_id)
                VALUES
                (:image_path, :location_name, :latitude, :longitude, :category, :description, :first_name, :last_name, :contact_details, :user_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'image_path'       => $data['image_path'],
            'location_name'    => $data['location_name'],
            'latitude'         => $data['latitude'],
            'longitude'        => $data['longitude'],
            'category'         => $data['category'],
            'description'      => $data['description'],
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'contact_details'  => $data['contact_details'],
            'user_id'          => $data['user_id'],
        ]);
    }

    // Future methods:
    // public function findById(int $id): array
    // public function findAll(): array
}
