<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Models\MenuItem;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class MenuItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        $this->crud->setModel("App\Models\MenuItem");
        $this->crud->setRoute(config('backpack.base.route_prefix').'/menu-item');
        $this->crud->setEntityNameStrings('menu item', 'menu items');

        $this->crud->enableReorder('name', 3);

        $this->crud->operation('list', function () {
            $this->crud->addColumn([
                'name' => 'name',
                'label' => 'Label',
            ]);
            $this->crud->addColumn([
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => "\App\Models\MenuItem",
            ]);

            $this->crud->addColumn([
                'name' => 'position',
                'label' => 'Position',
            ]);

            $this->crud->addColumn([
                'name' => 'link',
                'label' => 'Link',
            ]);

        });

        $this->crud->operation(['create', 'update'], function () {
            $this->crud->addField([
                'name' => 'name',
                'label' => 'Label',
            ]);
            $this->crud->addField([
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => "\App\Models\MenuItem",
            ]);

            $this->crud->addField(['name' => 'position', 'label' => 'Position on page',
                'type' => 'select_from_array',
                'options' => MenuItem::getMenuPositions(),
                'allows_null' => false,
                'default' => 'top',
            ]);
            $this->crud->addField(['name' => 'sort', 'type' => 'number', 'label' => 'Sort','default'=>CommonHelper::SORT_DEFAULT]);


            $this->crud->addField([
                'name' => ['type', 'link', 'page_id'],
                'label' => 'Type',
                'type' => 'page_or_link',
                'page_model' => '\Backpack\PageManager\app\Models\Page',
            ]);
        });
    }
}
