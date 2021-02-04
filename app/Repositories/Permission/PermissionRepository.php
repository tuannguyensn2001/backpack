<?php


namespace App\Repositories\Permission;


use App\Models\Permission;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facade as Debugbar;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{

    public function getModel(): string
    {
        return Permission::class;
    }

    public function getTable(): \Illuminate\Database\Query\Builder
    {
        return DB::table('permissions');
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function divideByModule()
    {
        $modules = $this->getModules();
        $result = [];

        foreach($modules as $module){
            $result[$module->module] = null;
        }

        foreach($result as $key=>&$value){
            $value = $this->getPermissionByModule($key);
        }
        return $result;


    }

    private function getModules()
    {
        return $this->model
            ->select('module')
            ->distinct()
            ->get();
    }

    private function getPermissionByModule($module)
    {
        return $this->model
            ->select('id','name')
            ->where('module',$module)
            ->get();
    }
}
