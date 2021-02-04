<?php


namespace App\Repositories\Base;


interface BaseRepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create($data);

    public function update($id,$data);

    public function delete($id);
}
