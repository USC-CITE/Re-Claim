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
                    first_name, last_name, contact_details, user_id, archive_date
                )
                VALUES
                (
                    'lost', :item_name, :image_path, :category, :description, :event_date, :status,
                    :location_name, :room_number, :latitude, :longitude,
                    :first_name, :last_name, :contact_details, :user_id, DATE_ADD(NOW(), INTERVAL 30 DAY
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
                    AND status != 'Archived'
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

    /**
     * Archive Lost-Items.
     */

    public function autoArchiveExpired(): void
    {
        $sql = "UPDATE lost_and_found_items
                SET status = 'Archived'
                WHERE item_type = 'lost'
                AND status = 'Unrecovered'
                AND archive_date IS NOT NULL
                AND archive_date <= NOW()";
        $this->db->exec($sql);
    }

    public function archiveByIds(array $ids, int $userId): bool
    {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE lost_and_found_items
                SET status = 'Archived'
                WHERE item_type = 'lost'
                AND user_id = ?
                AND id IN ($placeholders)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_merge([$userId], array_values($ids)));
    }

    public function postponeArchive(int $id, int $userId, int $days = 7): bool
    {
        $sql = "UPDATE lost_and_found_items
                SET archive_date = DATE_ADD(COALESCE(archive_date, NOW()), INTERVAL :days DAY)
                WHERE id = :id
                AND user_id = :user_id
                AND item_type = 'lost'
                AND status != 'Archived'";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'days' => $days,
            'id' => $id,
            'user_id' => $userId,
        ]);
    }
}