<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SeoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SeoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SeoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Seo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/seo');
        CRUD::setEntityNameStrings('seo', 'seos');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('page');
        CRUD::column('meta_title');
        CRUD::column('meta_description');
        CRUD::column('meta_keywords');

        $this->crud->addColumn(['name' => 'og_image', 'type' => 'image', 'label' => 'Og Image']);

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
        CRUD::setValidation(SeoRequest::class);

        $this->crud->addField(['name' => 'meta_title', 'type' => 'text', 'label' => 'Meta Title']);
        $this->crud->addField(['name' => 'meta_description', 'type' => 'textarea', 'label' => 'Meta Description']);

        CRUD::field('meta_keywords');
        $this->crud->addField(['name' => 'canonical', 'type' => 'text', 'label' => 'Canonical']);
      //  CRUD::field('og_image');
        $this->crud->addField(['name' => 'og_image', 'type' => 'image', 'label' => 'Og Image']);
       // CRUD::field('page');

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
}
