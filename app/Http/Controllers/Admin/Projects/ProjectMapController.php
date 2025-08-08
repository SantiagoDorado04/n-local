<?php

namespace App\Http\Controllers\Admin\Projects;

use App\Models\Project;
use App\Http\Controllers\Controller;

class ProjectMapController extends Controller
{
    public function index($id)
    {
        $project = Project::with('problems.solutions.methodologies.indicators')->find($id);

        $tree = [
            'id' => $project->id,
            'name' => $project->title,
            'description' => $project->description,
            'problems' => []
        ];

        foreach ($project->problems as $problem) {
            $problemData = [
                'id' => $problem->id,
                'description' => $problem->description,
                'solutions' => []
            ];

            foreach ($problem->solutions as $solution) {
                $methodologyData = [];

                foreach ($solution->methodologies as $methodology) {
                    $indicatorData = [];

                    foreach ($methodology->indicators as $indicator) {
                        $indicatorData[] = [
                            'id' => $indicator->id,
                            'description' => $indicator->title
                        ];
                    }

                    $methodologyData[] = [
                        'id' => $methodology->id,
                        'name' => $methodology->title,
                        'indicators' => $indicatorData
                    ];
                }

                    $solutionData = [
                    'id' => $solution->id,
                    'description' => $solution->description,
                    'methodologies' => $methodologyData
                ];

                $problemData['solutions'][] = $solutionData;
            }

            $tree['problems'][] = $problemData;
        }

        /* return response()->json($tree); */

        return view('mind');
    }
}
