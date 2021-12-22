<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyHistory;
use App\Models\UserSurvey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return Application|Factory|View
     */
    public function surveys()
    {
        $surveys = Survey::query()->with(['surveyItems', 'currentUserSurvey'])->get();
        return view('survey.surveys', compact('surveys'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function survey($id)
    {
        $survey = Survey::query()->with(['surveyItems.inputType', 'surveyItems.surveyStep'])->findOrFail($id);
        return view('survey.survey', compact('survey'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function surveySave(Request $request, $id): RedirectResponse
    {
        $userSurveyQuery = UserSurvey::query();
        $userSurveyQuery->where([
            'user_id'   => auth()->id(),
            'survey_id' => $id,
        ])->delete();
        $userSurvey = $userSurveyQuery->create([
            'user_id'   => auth()->id(),
            'survey_id' => $id,
        ]);

        $surveyHistory = [];
        foreach ($request->except('_token') as $surveyItem => $surveyItemValue) {

            $surveyHistory[] = [
                'user_survey_id' => $userSurvey->id,
                'survey_item_id' => explode("_", $surveyItem)[2],
                'survey_value'   => trim(is_array($surveyItemValue)
                    ? implode(", ", $surveyItemValue)
                    : $surveyItemValue),
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        SurveyHistory::query()->insert($surveyHistory);

        session()->flash('Survey Saved!');
        return redirect()->route('home');
    }
}
