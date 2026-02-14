<?php
/**
 * Layer: Model
 * Purpose: Handle database operations for LOST items
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
        $this->db = Database::connect($config['db']);
    }

    /**
     * Insert a LOST item into the unified table.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO lost_and_found_items
                (
                    item_type, item_name, image_path, category, description, event_date, status,
                    location_name, room_number, latitude, longitude,
                    first_name, last_name, contact_details, user_id
                )
                VALUES
                (
                    'lost', :item_name, :image_path, :category, :description, :event_date, :status,
                    :location_name, :room_number, :latitude, :longitude,
                    :first_name, :last_name, :contact_details, :user_id
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'item_name'       => $data['item_name'],
            'image_path'      => $data['image_path'],
            'category'        => $data['category'],
            'description'     => $data['description'],
            'event_date'      => $data['event_date'],
            'status'          => $data['status'] ?? 'Unrecovered',

            'location_name'   => $data['location_name'],
            'room_number'     => $data['room_number'],
            'latitude'        => $data['latitude'],
            'longitude'       => $data['longitude'],

            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'],
            'contact_details' => $data['contact_details'],
            'user_id'         => $data['user_id'],
        ]);
    }

    /**
     * List all LOST items (for /lost page).
     */
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM lost_and_found_items
                WHERE item_type = 'lost'
                ORDER BY event_date DESC, created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function markAsRecovered(int $id, int $userId): bool
    {
        $sql = "UPDATE lost_and_found_items
                SET status = 'Recovered'
                WHERE id = :id
                AND user_id = :user_id
                AND item_type = 'lost'
                AND status = 'Unrecovered'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        return $stmt->rowCount() > 0;
    }
}