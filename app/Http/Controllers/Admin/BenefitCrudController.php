<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Requests\BenefitRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BenefitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BenefitCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Benefit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/benefit');
        CRUD::setEntityNameStrings('benefit', 'benefits');
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
        CRUD::column('description');
        $this->crud->addColumn(['name' => 'image', 'type' => 'image', 'label' => 'Image']);
        $this->crud->addColumn([
            'name' => 'active',
            'label' => 'Active',
            'type' => 'check',
        ]);
        CRUD::column('sort');

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
        CRUD::setValidation(BenefitRequest::class);

        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Title']);
        $this->crud->addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Description']);
        $this->crud->addField(['name' => 'image', 'type' => 'custom_image', 'label' => 'Image']);
        $this->crud->addField(['name' => 'alt', 'type' => 'text', 'label' => 'Image Alt']);
        $this->crud->addField(['name' => 'active', 'type' => 'toggle', 'label' => 'Active','view_namespace' => 'toggle-field-for-backpack::fields', 'default' => CommonHelper::ACTIVE]);

        $this->crud->addField(['name' => 'sort', 'type' => 'number', 'label' => 'Sort','default'=>CommonHelper::SORT_DEFAULT]);

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
