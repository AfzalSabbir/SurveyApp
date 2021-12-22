<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SurveyRequest;
use App\Models\SurveyItem;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SurveyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SurveyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Survey::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/survey');
        CRUD::setEntityNameStrings('survey', 'surveys');
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
        CRUD::column('title');
        CRUD::column('cover_image')->type('image');
        CRUD::column('welcome_message');
        CRUD::column('description');
        CRUD::column('complete_message');
        CRUD::column('surveyItems');
        CRUD::column('created_at');

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
        CRUD::setValidation(SurveyRequest::class);

        CRUD::field('title');
        CRUD::field('cover_image')->type('browse');
        CRUD::addField([
            'name'       => 'surveyItems',
            'label'      => 'Survey items',
            'type'       => 'select2_multiple',

            // optional
            'entity'     => 'surveyItems', // the method that defines the relationship in your Model
            'model'      => SurveyItem::class, // foreign key model
            'attribute'  => 'title', // foreign key attribute that is shown to user
            'pivot'      => true, // on create&update, do you need to add/delete pivot table entries?
            'select_all' => true, // show Select All and Clear buttons?

            // optional
            'options'    => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
        ]);
        CRUD::field('welcome_message')->type('tinymce');
        CRUD::field('description')->type('tinymce');
        CRUD::field('complete_message')->type('tinymce');

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

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
