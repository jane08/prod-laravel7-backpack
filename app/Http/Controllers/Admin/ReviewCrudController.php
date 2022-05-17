<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Requests\ReviewRequest;
use App\Http\Services\UserService;
use App\Models\Review;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ReviewCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReviewCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Review::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/review');
        CRUD::setEntityNameStrings('review', 'reviews');
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
        CRUD::column('name');
        $this->crud->addColumn(['name' => 'published_date', 'type' => 'date', 'label' => 'Date']);

        CRUD::column('content');
        CRUD::column('status');
        CRUD::column('sort');
        $this->crud->addField(['name' => 'main_page', 'type' => 'toggle', 'label' => 'Main Page','view_namespace' => 'toggle-field-for-backpack::fields', 'default' => CommonHelper::ACTIVE]);
        $this->crud->addColumn([
            'name' => 'main_page',
            'label' => 'Main Page',
            'type' => 'check',
        ]);
        $this->crud->addColumn(['name' => 'rating', 'type' => 'star', 'label' => 'Rating']);
        $this->crud->addColumn(['name' => 'image', 'type' => 'image', 'label' => 'Image']);
        $this->crud->addColumn([
            'label'     => 'Course', // Table column heading
            'type'      => 'select',
            'name'      => 'course_id', // the column that contains the ID of that connected entity;
            'entity'    => 'course', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => "App\Models\Course", // foreign key model
        ]);
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
        CRUD::setValidation(ReviewRequest::class);

        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Name']);


        $this->crud->addField(['name' => 'user_id', 'label' => 'Student',
            'type' => 'select_from_array',
            'options' => UserService::getUsersByRole("student"),
            'allows_null' => true,

        ]);
        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Title']);
        $this->crud->addField(['name' => 'content', 'type' => 'textarea', 'label' => 'Content']);
        $this->crud->addField(['name' => 'sort', 'type' => 'number', 'label' => 'Sort', 'default' => CommonHelper::SORT_DEFAULT]);
        $this->crud->addField(['name' => 'image', 'type' => 'image', 'label' => 'Image']);
        $this->crud->addField(['name' => 'alt', 'type' => 'text', 'label' => 'Image Alt']);
        $this->crud->addField(['name' => 'user_id', 'type' => 'text', 'label' => 'Student']);
        $this->crud->addField(['name' => 'special_word', 'type' => 'text', 'label' => 'Special Word on Main Page']);
        $this->crud->addField(['name' => 'status', 'label' => 'Status',
            'type' => 'select_from_array',
            'options' => Review::getStatuses(),
            'allows_null' => false,
            'default' => 'moderation',
        ]);
        $this->crud->addField(['name' => 'main_page', 'type' => 'toggle', 'label' => 'Show on Main Page','view_namespace' => 'toggle-field-for-backpack::fields', 'default' => CommonHelper::ACTIVE]);



        $this->crud->addField(
            [  // Select2
                'label'     => "Course",
                'type'      => 'select2',
                'name'      => 'course_id', // the db column for the foreign key

                // optional
                'entity'    => 'course', // the method that defines the relationship in your Model
                'model'     => "App\Models\Course", // foreign key model
                'attribute' => 'title', // foreign key attribute that is shown to user
                'default'   => 1, // set the default value of the select2

                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('title', 'ASC')->where('active', 1)->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

        $this->crud->addField(['name' => 'published_date', 'type' => 'date', 'label' => 'Date']);

        CRUD::addField([
            'view_namespace' => 'star-field-for-backpack::fields',
            'name' => 'rating',
            'type' => 'star',
            // 'label' => 'Rating', // (optional)
            // 'count' => 8, // (optional) the max rate count; default value is 5
            // 'default' => 6, // (optional) the default checked rate on new item creation
            // 'hint' => 'Cheer up!', // (optional)
            // 'options' => [ // (optional) customize the look
            //     'icon' => '★', // (optional) the default icon is ★
            //     'unchecked_color' => '#ccc', // (optional) the default value is #ccc
            //     'checked_color' => '#ffc700', // (optional) the default value is #ffc700
            //     'hover_color' => '#c59b08', // (optional) the default value is #c59b08
            // ],
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
