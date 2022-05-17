<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StaticTransRequest;
use App\Models\MenuItem;
use App\Models\StaticTrans;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StaticTransCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StaticTransCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StaticTrans::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/static-trans');
        CRUD::setEntityNameStrings('static trans', 'static trans');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('content');
        CRUD::column('keyword');
        CRUD::column('page');

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
        CRUD::setValidation(StaticTransRequest::class);

        $this->crud->addField(['name' => 'content', 'type' => 'textarea', 'label' => 'Content']);

        CRUD::field('keyword');
        CRUD::field('page');

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
        CRUD::setValidation(StaticTransRequest::class);
       // $this->setupCreateOperation();
        $this->crud->addField(['name' => 'content', 'type' => 'textarea', 'label' => 'Content']);

       // CRUD::field('keyword');
       // CRUD::field('page');
    }

    public function pages()
    {
        $pages = MenuItem::$pages;
        return view('vendor.backpack.base.static-pages.static-pages',['pages'=>$pages]);
    }

}
