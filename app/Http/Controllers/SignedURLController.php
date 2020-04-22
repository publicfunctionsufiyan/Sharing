<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Signedurl;
use App\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class SignedURLController extends Controller
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
    public function store(Request $request, File $file)
    {

        if ($file) {

            if ($request->input('day')) {
                $count = $request->day;
                $expiry = now()->addDay($count);
            } elseif ($request->input('hour')) {
                $count = $request->hour;
                $expiry = now()->addHour($count);
            } elseif ($request->input('minute')) {
                $count = $request->minute;
                $expiry = now()->addMinute($count);
            }




            $hash =  $input['hash_key'] = Str::random(16);

            $path = URL::temporarySignedRoute('my.file', $expiry, [
                'hash' =>  $hash,

            ]);

            $input['files_id'] = $file->id;
            $input['temp_url'] = $path;
            $input['expiry_time'] = $expiry;

            $input['isEnable'] = 1;
            $tempURL = Signedurl::create($input);
            return response()->json(['success' => true], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFiles(Request $request, $id)
    {
        $isEnable = Signedurl::where('hash_key', $id)->get('isEnable');



        if ($isEnable[0]->isEnable == 1) {

            $file_id = Signedurl::where('hash_key', $id)->get('files_id');
            $path = File::whereIn('id', $file_id)->first()->path;
            return Storage::download($path);
        } else {

            return 'Your URL is disabled now';
        }
    }

    public function isEnable(Request $request, Signedurl $signed_url)
    {

if($signed_url)
{

    $urlId = Signedurl::where('id', $signed_url->id)->get('isEnable');


    if ($urlId[0]->isEnable == 1) {

        return Signedurl::where('id', $signed_url->id)->update(['isEnable' => false]);
    } else {
        return Signedurl::where('id', $signed_url->id)->update(['isEnable' => true]);
    }
}

    }

    public function showLinksByFile($id)
    {
        $file = File::find($id);
        $Signedurls = $file->Signedurls;
        return response()->json(['Signed URLs' => $Signedurls], 200);
    }

    public function showAllLinks()
    {
        return Signedurl::all();
    }

    public function delete($id)
    {
        $signedurl = Signedurl::findOrFail($id);
        $signedurl->delete();

        return 'URL deleted successfully';
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
