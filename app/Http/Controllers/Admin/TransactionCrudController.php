<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TransactionRequest;
use App\Http\Services\TariffService;
use App\Http\Services\UserService;
use App\Models\Course;
use App\Models\Tariff;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('transaction', 'transactions');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('create');
        CRUD::column('course_id');
        CRUD::column('user_id');

        $this->crud->addColumn(['name' => 'start_date', 'type' => 'datetime', 'label' => 'Start Date']);
        $this->crud->addColumn(['name' => 'end_date', 'type' => 'datetime', 'label' => 'End Date']);

        CRUD::column('message');

        CRUD::column('status');
        CRUD::column('sum');
        CRUD::column('tariff_id');
        CRUD::column('tariff_type');


        //filters
        $courses = Course::select('id','title')->published()->get()->pluck('title', 'id')->toArray();

        $this->crud->addFilter([
            'name' => 'course_id',
            'type' => 'dropdown',
            'label'=> 'Course'
        ],$courses, function($value) { // if the filter is active
            $this->crud->addClause('where', 'course_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'user_id',
            'type' => 'select2',
            'label'=> 'Users'
        ], function() {
            return UserService::getUsersByRole("student");
        }, function($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });

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
        CRUD::setValidation(TransactionRequest::class);
        $courseId = $_GET['course_id']??'';
        $tariffId = $_GET['tariff_id']??'';
        $type = $_GET['type']??'extend';

        if(!empty($tariffId))
        {
            $tariff = TariffService::getOne($tariffId);
        }

        $courseHasTariff = Tariff::courseHasTariff($courseId??'',$tariffId??'',$type??'');



      /*  $this->crud->addField(
            [  // Select2
                'label'     => "Course",
                'type'      => 'select2',
                'name'      => 'course_id', // the db column for the foreign key

                // optional
                'entity'    => 'course', // the method that defines the relationship in your Model
                'model'     => "App\Models\Course", // foreign key model
                'attribute' => 'title', // foreign key attribute that is shown to user
                'default'   => $courseId, // set the default value of the select2
                'attributes' => [
                    'readonly' => 'readonly',

                ],
                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('title', 'ASC')->where('active', 1)->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

        $this->crud->addField(
            [  // Select2
                'label'     => "Tariff",
                'type'      => 'select2',
                'name'      => 'tariff_id', // the db column for the foreign key

                // optional
                'entity'    => 'tariff', // the method that defines the relationship in your Model
                'model'     => "App\Models\Tariff", // foreign key model
                'attribute' => 'title', // foreign key attribute that is shown to user
                'default'   => $tariffId, // set the default value of the select2
                'attributes' => [
                    'readonly' => 'readonly',

                ],
                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('title', 'ASC')->where('active', 1)->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);*/

        //CRUD::field('user_id');
        $this->crud->addField(['name' => 'course_id', 'type' => 'hidden', 'label' => 'course','default'   => $courseId,

        ]);
        $this->crud->addField(['name' => 'tariff_id', 'type' => 'hidden', 'label' => 'tariff','default'   => $tariffId,

        ]);
        $this->crud->addField(['name' => 'tariff_type', 'type' => 'text', 'label' => 'Type','default'   => $type,
            'attributes' => [
                'readonly' => 'readonly',

            ],
            ]);
        $this->crud->addField(['name' => 'sum', 'type' => 'text', 'label' => 'Sum','default' => $tariff->price??0,
            'attributes' => [
                'readonly' => 'readonly',

            ],
        ]);

        $this->crud->addField(
            [  // Select2
                'label'     => "User",
                'type'      => 'select2',
                'name'      => 'user_id', // the db column for the foreign key

                // optional
                'entity'    => 'user', // the method that defines the relationship in your Model
                'model'     => "App\Models\User", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
               // 'default'   => $courseId, // set the default value of the select2

                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('active', 1)->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

     //   CRUD::field('start_date');
       // CRUD::field('end_date');
        $this->crud->addField(['name' => 'start_date', 'type' => 'datetime', 'label' => 'Start Date']);
        $this->crud->addField(['name' => 'end_date', 'type' => 'datetime', 'label' => 'End Date']);

        CRUD::field('message');

        //CRUD::field('status');

        $this->crud->addField(['name' => 'status', 'label' => 'Status',
            'type' => 'select_from_array',
            'options' => Transaction::getStatuses(),
            'allows_null' => false,
            'default' => 'pending',
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
        CRUD::setValidation(TransactionRequest::class);


        /*  $this->crud->addField(
              [  // Select2
                  'label'     => "Course",
                  'type'      => 'select2',
                  'name'      => 'course_id', // the db column for the foreign key

                  // optional
                  'entity'    => 'course', // the method that defines the relationship in your Model
                  'model'     => "App\Models\Course", // foreign key model
                  'attribute' => 'title', // foreign key attribute that is shown to user
                  'default'   => $courseId, // set the default value of the select2
                  'attributes' => [
                      'readonly' => 'readonly',

                  ],
                  // also optional
                  'options'   => (function ($query) {
                      return $query->orderBy('title', 'ASC')->where('active', 1)->get();
                  }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
              ]);

          $this->crud->addField(
              [  // Select2
                  'label'     => "Tariff",
                  'type'      => 'select2',
                  'name'      => 'tariff_id', // the db column for the foreign key

                  // optional
                  'entity'    => 'tariff', // the method that defines the relationship in your Model
                  'model'     => "App\Models\Tariff", // foreign key model
                  'attribute' => 'title', // foreign key attribute that is shown to user
                  'default'   => $tariffId, // set the default value of the select2
                  'attributes' => [
                      'readonly' => 'readonly',

                  ],
                  // also optional
                  'options'   => (function ($query) {
                      return $query->orderBy('title', 'ASC')->where('active', 1)->get();
                  }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
              ]);*/

        //CRUD::field('user_id');


        $this->crud->addField(
            [  // Select2
                'label'     => "User",
                'type'      => 'select2',
                'name'      => 'user_id', // the db column for the foreign key

                // optional
                'entity'    => 'user', // the method that defines the relationship in your Model
                'model'     => "App\Models\User", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'default'   => $courseId, // set the default value of the select2

                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('active', 1)->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

        //   CRUD::field('start_date');
        // CRUD::field('end_date');
        $this->crud->addField(['name' => 'start_date', 'type' => 'datetime', 'label' => 'Start Date']);
        $this->crud->addField(['name' => 'end_date', 'type' => 'datetime', 'label' => 'End Date']);

        CRUD::field('message');

        //CRUD::field('status');

        $this->crud->addField(['name' => 'status', 'label' => 'Status',
            'type' => 'select_from_array',
            'options' => Transaction::getStatuses(),
            'allows_null' => false,
            'default' => 'pending',
        ]);

    }
}
