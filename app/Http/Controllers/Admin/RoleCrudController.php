<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PermissionRoute;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Request;
use Prologue\Alerts\Facades\Alert;

/**
 * Class RoleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    private $permissionRoute;
    private $permissionRepository;

    public function __construct(PermissionRoute $permissionRoute,PermissionRepositoryInterface $permissionRepository)
    {
        parent::__construct();
        $this->permissionRoute = $permissionRoute;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Role::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/role');
        CRUD::setEntityNameStrings('role', 'roles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('display_name');
        CRUD::column('description');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @param PermissionRoute $permissionRoute
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoleRequest::class);

        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('display_name');
        CRUD::column('description');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'quyền'
        ]);

        $this->permissionRoute->load();



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;

        $this->data['permissions'] = $this->permissionRepository->divideByModule();

        return view('backpack.role.create',$this->data);
    }

    public function store()
    {
      $request = $this->crud->getRequest();

      $data = $request->except(['_token','name','http_referrer','save_action']);

        Alert::add('success', 'Thêm quyền mới thành công')->flash();
      return redirect()->back();

    }


}
