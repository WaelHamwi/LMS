<?php

namespace App\Repositories\Student;


interface FeesRepositoryInterface
{
    public function getAllFees();
    public function createFee(array $data);
    public function getFeeById($id);
    public function updateFee($id, array $data);
    public function delete($id);
    public function bulkDelete(array $ids);
}
