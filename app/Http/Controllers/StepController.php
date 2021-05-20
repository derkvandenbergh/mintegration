<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

use App\Models\Route;

use App\Services\StepService;
use App\Services\StepFunctionService;
use App\Services\StepArgumentService;

class StepController extends Controller
{

    protected $stepService;
    protected $functionService;
    protected $argumentService;

    public function __construct(
        StepService $stepService, 
        StepFunctionService $functionService,
        StepArgumentService $argumentService
    ) {
        $this->stepService = $stepService;
        $this->functionService = $functionService;
        $this->argumentService = $argumentService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        $steps = $this->stepService->findAllFromRoute($route->id);

        $functions = $this->functionService->findAllWithParameters();

        return view('models.steps.index', compact('steps', 'route', 'functions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route, Step $step)
    {
        $data = $request->validate([
            "steps"    => ['required', 'array'],
            "steps.*.name"  => ['required', 'string', 'max:255'], // TODO make this a unique rule for within route
            "steps.*.step_function_id" => ['required', 'integer'],
            'steps.*.arguments' => ['required', 'array', 'min:1']
        ]);

        $this->stepService->deleteAllFromRoute($route->id);

        $order = 1;

        foreach($data['steps'] as $step) {
            $step['route_id'] = $route->id;
            $step['order'] = $order;
            
            $arguments = $step['arguments'];
            unset($step['arguments']);

            $step = $this->stepService->store($step);

            foreach($arguments as $key=>$val) {
                $argument['parameter_id'] = $key;
                $argument['value'] = $val;
                $argument['step_id'] = $step->id;

                $this->argumentService->store($argument);
            }

            $order++;

        }

        return redirect('/routes/' . $route->id)->with('success', 'Steps of route with name "' . $route->title . '" have succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function component(Request $request)
    {
        $functions = $this->functionService->findAllWithParameters();
        $view = $this->renderStepComponent($request['number'], $functions);

        return json_encode( ['view' => $view]);
    }

    public function renderStepComponent($number, $functions)
    {
        return view('components.subpages.components.route-step-form', compact('number', 'functions'))->render();
    } 
}
