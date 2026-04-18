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

    # ensure expired items are auto-archived before fetching
    public function autoArchiveExpired(): void
    {
        $sql = "UPDATE lost_and_found_items 
                SET is_archived = 1,
                    archive_date = NOW()
                WHERE item_type = 'found'
                AND status IN ('Unrecovered', 'Recovered') 
                AND archive_date IS NOT NULL 
                AND archive_date <= NOW()";
        $this->db->exec($sql);
    }

    public function getAll(): array
    {
        $this->autoArchiveExpired(); #run auto archive first

        $sql = "SELECT * FROM lost_and_found_items 
                WHERE item_type = 'found' 
                    AND is_archived = 0
                ORDER BY event_date DESC, created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    
    public function create(array $data): bool
    {
        $sql = "INSERT INTO lost_and_found_items 
                (item_type, image_path, item_name, event_date, location_name, room_number, latitude, longitude, category, description, first_name, last_name, contact_details, user_id, status, archive_date)
                VALUES
                (:item_type, :image_path, :item_name, :event_date, :location_name, :room_number, :latitude, :longitude, :category, :description, :first_name, :last_name, :contact_details, :user_id, 'Unrecovered', DATE_ADD(NOW(), INTERVAL 30 DAY))";

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

    # updates rows that belong to user, type of 'found', and status of 'Unrecovered'
    public function markAsRecovered(int $id, int $userId): bool
    {
        $sql = "UPDATE lost_and_found_items
                SET status = 'Recovered'
                WHERE id = :id
                  AND user_id = :user_id
                  AND item_type = 'found'
                  AND status = 'Unrecovered'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function archiveByIds(array $ids, int $userId): bool
    {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE lost_and_found_items 
                SET is_archived = 1,
                    archive_date = NOW()
                WHERE item_type = 'found'
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
                AND item_type = 'found'
                AND is_archived = 0";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'days' => $days,
            'id' => $id,
            'user_id' => $userId,
        ]);
    }

}