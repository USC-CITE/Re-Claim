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
        $sql = "SELECT * FROM lost_and_found_items ORDER BY event_date DESC, created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function create(array $data): bool
    {
        $sql = "INSERT INTO lost_and_found_items 
                (item_type, image_path, item_name, event_date, location_name, room_number, latitude, longitude, category, description, first_name, last_name, contact_details, user_id, status)
                VALUES
                (:item_type, :image_path, :item_name, :event_date, :location_name, :room_number, :latitude, :longitude, :category, :description, :first_name, :last_name, :contact_details, :user_id, 'Unrecovered')";

        $stmt = $this->db->prepare($sql);

        // Ensure required numeric columns have sane defaults when not provided by controller
        $latitude = isset($data['latitude']) && $data['latitude'] !== null ? $data['latitude'] : 0;
        $longitude = isset($data['longitude']) && $data['longitude'] !== null ? $data['longitude'] : 0;

        return $stmt->execute([
            'item_type'        => $data['item_type'] ?? 'found',
            'image_path'       => $data['image_path'],
            'item_name'        => $data['item_name'],
            'event_date'       => $data['date_found'],
            'location_name'    => $data['location_name'],
            'room_number'      => $data['room_number'] ?? null,
            'latitude'         => $latitude,
            'longitude'        => $longitude,
            'category'         => $data['category'],
            'description'      => $data['description'],
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'contact_details'  => $data['contact_details'],
            'user_id'          => $data['user_id'],
        ]);
    }
}