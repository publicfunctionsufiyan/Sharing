<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\File;
use App\Project;
use App\User;



class FilesController extends Controller
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

    public function delete($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return 'File deleted successfully';

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
    public function store(Request $request)
    {

        if($request->privatable_type=='App\User')
        {

            $privatable_id = $request->privatable_id;
            if(User::find($privatable_id))
            {

                 if($request->hasFile('file'))
                {
                    $path = $request->file('file')->store('shared_files');
                    $complete_path = "http://192.168.1.167/file-storage/storage/app/".$path;
                    $input = $request->all();
                    $input['path'] = $complete_path;
                    $store = File::create($input);

                    $input = $request->all();
                    return response()->json(['success' => true], 200);

                }




          }
            else
            {
                return 'User Not Available';

            }
        }







        elseif($request->privatable_type=='App\Project')
        {
            $privatable_id = $request->privatable_id;
            if(Project::find($privatable_id))
            {

                 if($request->hasFile('file'))
                {
                    $path = $request->file('file')->store('shared_files');
                    $input = $request->all();
                    $input['path'] = $path;
                    $store = File::create($input);

                    $input = $request->all();
                    return response()->json(['success' => true], 200);
                }



          }
            else
            {
                return 'Project Not Available';

            }

        }

        else{

            return "Please enter correct data";
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFilesByProject($id)
    {
        $project = Project::find($id);
        $files = $project->Files;
        return response()->json(['Files' => $files], 200);

    }

    public function showFilesByUser($id)
    {
        $user = User::find($id);
        $files = $user->Files;
        return response()->json(['Files' => $files], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
