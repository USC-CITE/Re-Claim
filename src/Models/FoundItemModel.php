<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class FoundItemModel
{
    private PDO $db;

    public function __construct(array $config)
    {
        $this->db = Database::connect($config['db']);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM found_items ORDER BY date_found DESC, created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function create(array $data): bool
    {
        $sql = "INSERT INTO found_items 
                (image_path, item_name, date_found, location_name, latitude, longitude, category, description, first_name, last_name, contact_details, user_id, status)
                VALUES
                (:image_path, :item_name, :date_found, :location_name, :latitude, :longitude, :category, :description, :first_name, :last_name, :contact_details, :user_id, 'Unclaimed')";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'image_path'       => $data['image_path'],
            'item_name'        => $data['item_name'],
            'date_found'       => $data['date_found'],
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
}