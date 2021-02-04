<?php


namespace App\Helpers;



use App\Models\Permission;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\countOf;

class PermissionRoute
{
    public function load()
    {
        $routes =  Route::getRoutes();

        $routePermission = [];

        foreach ($routes as $key => $route){
            $middleware = $route->action['middleware'];
            try {
                $count = count($middleware);
                $name = explode(".",$route->action['as']);
                if ($count >= 3 && $name[0] === 'permission'){
                    $routePermission[] = $route;

                    $check = DB::table('permissions')
                        ->where('name',$route->action['as'])
                        ->first();

                    if (!$check) {
                        DB::table('permissions')
                            ->insert([
                                'name' => $name[1].".".$name[2],
                                'module' => explode(".",$route->action['as'])[1],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                    }

                }
            } catch (\Exception $exception){

            }

        }










    }
}
