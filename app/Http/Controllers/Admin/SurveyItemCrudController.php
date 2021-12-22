<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SurveyItemRequest;
use App\Models\Survey;
use App\Models\SurveyStep;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SurveyItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SurveyItemCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SurveyItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/survey-item');
        CRUD::setEntityNameStrings('survey item', 'survey items');
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
        CRUD::addColumn([
            'name'     => 'input_type_id',
            'type'     => 'closure',
            'function' => function ($entity) {
                return "<span class='text-capitalize'>"
                       . $entity->inputType->type ?? $entity->input_type_id
                                                     . "</span>";
            }
        ]);
        CRUD::column('is_multiple')->type('boolean');
        CRUD::column('options');
        CRUD::addColumn([
            'name'     => 'survey_step_id',
            'type'     => 'closure',
            'function' => function ($entity) {
                return "<span class='text-capitalize'>"
                       . $entity->surveyStep->title ?? $entity->survey_step_id
                                                       . "</span>";
            }
        ]);
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
        CRUD::setValidation(SurveyItemRequest::class);

        CRUD::field('title');
        CRUD::addField([
            'name'       => 'input_type_id',
            'type'       => 'select',
            'entity'     => 'inputType',
            'attributes' => [
                'class' => 'text-capitalize form-control col-sm-12'
            ]
        ]);
        CRUD::field('is_multiple');
        CRUD::addField([
            'name'  => 'options',
            'label' => 'Options <small><code>[Note: If is multiple checked then input the options in comma (,) separate]</code></small>',
        ]);
        CRUD::addField([
            'name'   => 'survey_step_id',
            'type'   => 'select',
            'entity' => 'surveyStep',
            'model'  => SurveyStep::class,
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

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
