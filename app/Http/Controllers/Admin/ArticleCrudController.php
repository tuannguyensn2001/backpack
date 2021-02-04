<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {store as traitStore;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title');
        CRUD::column('url');
        CRUD::column('content');
        CRUD::column('category_id');
        CRUD::column('tag_id');
        CRUD::column('status_id');



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
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ArticleRequest::class);

        CRUD::column('title');
        CRUD::column('url');
        CRUD::column('content');
        CRUD::column('category_id');
        CRUD::column('tag_id');
        CRUD::column('status_id');

        Widget::add([
            'type'         => 'alert',
            'class'        => 'alert alert-danger mb-2',
            'heading'      => 'Important information!',
            'content'      => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti nulla quas distinctio veritatis provident mollitia error fuga quis repellat, modi minima corporis similique, quaerat minus rerum dolorem asperiores, odit magnam.',
            'close_button' => true, // show close button or not
        ])->to('after_content');


        $this->crud->addFields([
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Tên bài viết',
            ],
            [
                'name' => 'url',
                'type' => 'text',
                'label' => 'Url',
            ],
            [
                'name' => 'content',
                'label' => 'Nội dung bài viết',
                'type' => 'summernote',
            ],
            [
                'name' => 'category_id',
                'label' => 'Danh mục',
                'type' => 'select',
                'entity' => 'category',
                'attribute' => 'name',
                'model' => 'App\Models\Category',
            ],
            [
                'name' => 'tag_id',
                'label' => 'Thẻ',
                'type' => 'select',
                'entity' => 'tag',
                'attribute' => 'name',
                'model' => 'App\Models\Tag',
            ],
            [
                'name' => 'status_id',
                'label' => 'Trạng thái',
                'type' => 'select',
                'entity' => 'status',
                'attribute' => 'name',
                'model' => 'App\Models\Status',
            ]
        ]);


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

    public function store()
    {
//        try {
//            $this->traitStore();
//        } catch (\Exception $exception){
//            dd($exception->getMessage());
//        }
        dd($this->crud->getStrippedSaveRequest());
    }


}
