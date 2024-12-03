<?php
namespace App\Repositories\Student;


interface PaymentFeeStudentRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function destroy($id);

}