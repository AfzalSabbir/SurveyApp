<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserSurveyRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserSurveyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserSurveyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    //use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\UserSurvey::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-survey');
        CRUD::setEntityNameStrings('user survey', 'user surveys');
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
        CRUD::addColumn([
            'name'     => 'user_id',
            'type'     => 'closure',
            'function' => function ($entity) {
                return $entity->user->name;
            },
        ]);
        CRUD::addColumn([
            'name'   => 'survey_id',
            'entity' => 'survey',
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
        CRUD::setValidation(UserSurveyRequest::class);


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
        $this->crud->setShowContentClass('col-md-12');
        $this->setupListOperation();
        CRUD::addColumn([
            'name'     => 'survey_history',
            'type'     => 'closure',
            'function' => function ($entity) {
                $surveyHistories = $entity->surveyHistories()
                    ->with(['surveyItem.inputType', 'surveyItem.surveyStep'])->get();
                $response        = "<table>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Survey Item</th>
                                            <th>Survey Step</th>
                                            <th>Survey Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
                foreach ($surveyHistories as $key => $surveyHistory) {
                    $response .= "<tr>
                                    <td>" . ($key + 1) . "</td>
                                    <td>{$surveyHistory->surveyItem->title}</td>
                                    <td>{$surveyHistory->surveyItem->surveyStep->title}</td>
                                    <td>$surveyHistory->survey_value</td>
                                </tr>";
                }

                $response .= "</tbody></table>";
                return $response;
            },
        ]);
    }
}
