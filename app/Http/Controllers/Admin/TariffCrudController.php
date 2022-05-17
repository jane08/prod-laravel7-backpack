<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Requests\TariffRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TariffCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TariffCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Tariff::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tariff');
        CRUD::setEntityNameStrings('tariff', 'tariffs');
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
        CRUD::column('code');
        CRUD::column('price');
        CRUD::column('sort');
       /* $this->crud->addColumn([
            'name' => 'active',
            'label' => 'Active',
            'type' => 'check',
        ]);*/

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
        CRUD::setValidation(TariffRequest::class);

        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Title']);
        $this->crud->addField(['name' => 'content', 'type' => 'textarea', 'label' => 'Content']);
        CRUD::field('code');

        $this->crud->addField(['name' => 'price', 'type' => 'text', 'label' => 'Price']);
        $this->crud->addField(['name' => 'sort', 'type' => 'number', 'label' => 'Sort', 'default' => CommonHelper::SORT_DEFAULT]);

      //  $this->crud->addField(['name' => 'active', 'type' => 'toggle', 'label' => 'Active','view_namespace' => 'toggle-field-for-backpack::fields', 'default' => CommonHelper::ACTIVE]);
        $this->crud->addField([   // Table
            'name'            => 'pluses',
            'label'           => 'Pluses',
            'type'            => 'table',
            'entity_singular' => 'option', // used on the "Add X" button
            'columns'         => [
                'name'  => 'Name',
               // 'id'  => 'id',
            ],
            'max' => 1000, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table

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
}
