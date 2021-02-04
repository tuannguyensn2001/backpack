<?php


namespace App\Repositories\Base;


use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepository
{
    protected $model;
    protected $table;

    public function __construct()
    {
        $this->setModel();
        $this->setTable();
    }

    abstract public function getModel();

    public function setModel()
    {
        try {
            $this->model = app()->make($this->getModel());
        } catch (BindingResolutionException $e) {
        }
    }

    public function getTable()
    {

    }

    public function setTable()
    {
        try {
            $this->table = $this->getTable();
        } catch (\Exception $exception) {

        }
    }

}
