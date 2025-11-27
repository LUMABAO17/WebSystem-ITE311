<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'course_id', 
        'title',
        'description',
        'file_name', 
        'stored_name',
        'file_type',
        'file_size',
        'uploaded_by',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Insert a new material record
     * 
     * @param array $data Material data
     * @return mixed Insert ID or false
     */
    public function insertMaterial(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     * 
     * @param int $course_id Course ID
     * @return array List of materials
     */
    public function getMaterialsByCourse(int $course_id): array
    {
        return $this->where('course_id', $course_id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get a single material by ID
     * 
     * @param int $material_id Material ID
     * @return array|null Material data or null
     */
    public function getMaterialById(int $material_id): ?array
    {
        return $this->find($material_id);
    }

    /**
     * Delete a material record
     * 
     * @param int $material_id Material ID
     * @return bool Success status
     */
    public function deleteMaterial(int $material_id): bool
    {
        return $this->delete($material_id) !== false;
    }
}
