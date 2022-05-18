<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
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
        CRUD::column('slug');
        CRUD::column('description');
        CRUD::column('price');
        CRUD::column('qty');
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
        CRUD::setValidation(ProductRequest::class);

        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Title']);
        $this->crud->addField(['name' => 'slug', 'type' => 'text', 'label' => 'Slug']);
        $this->crud->addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Description']);
        $this->crud->addField(['name' => 'image', 'type' => 'custom_image', 'label' => 'Image']);
        $this->crud->addField(['name' => 'alt', 'type' => 'text', 'label' => 'Image Alt']);
        $this->crud->addField(['name' => 'active', 'type' => 'toggle', 'label' => 'Active','view_namespace' => 'toggle-field-for-backpack::fields', 'default' => CommonHelper::ACTIVE]);

        $this->crud->addField(['name' => 'sort', 'type' => 'number', 'label' => 'Sort','default'=>CommonHelper::SORT_DEFAULT]);

        $this->crud->addField(['name' => 'price', 'type' => 'text', 'label' => 'Price']);
        $this->crud->addField(['name' => 'qty', 'type' => 'text', 'label' => 'Qty']);

        $this->crud->addField(['name' => 'meta_title', 'type' => 'text', 'label' => 'Meta Title']);
        $this->crud->addField(['name' => 'meta_description', 'type' => 'textarea', 'label' => 'Meta Description']);

        CRUD::field('meta_keywords');
        $this->crud->addField(['name' => 'canonical', 'type' => 'text', 'label' => 'Canonical']);

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
