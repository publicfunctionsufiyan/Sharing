<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {


        $validator = Validator::make($request->all(), ['name' => 'required', 'URL' => 'required', 'image' => 'required']);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 401);

        }
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = $user->id;
        $project = Project::create($input);




             $project->addMedia($input['image'])->toMediaCollection('project-image');


        return response()->json(['success' => $project], 200);

    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        $project->clearMediaCollection('project-image');

        return 'Project deleted successfully';

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAllProjects(Request $request)
    {
        return Project::all();


    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $project->getMedia('project-image');
        return $project;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $input = $request->all();
        $project->update($request->all());

        if($request->hasFile('image'))
        {
          $project->clearMediaCollection('project-image');
          $project->addMedia($input['image'])->toMediaCollection('project-image');

          // Media::where('model_type', 'App\Project')->where('model_id', $id)->delete();



        }

        return 'Project updated successfully';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showProjectsByUser($id)
    {

        return Project::where('user_id',$id)->get();

        // $project->getMedia('project-image');

    }


}
