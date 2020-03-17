<?php

namespace App\Http\Controllers;
use Str;
use Storage;
use App\Picture;
use App\Http\Requests\PictureRequest;
use Illuminate\Http\Request;

use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('pictures.index', compact('pictures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
        ]);

        $bucket = env('AWS_BUCKET');
        $key = "pictures/NB" . str::random(40);
        $formInputs = ['acl' => 'private', 'key' => $key];

        $options = [
            ['acl' => 'private'],
            ['bucket' => $bucket],
            ['eq','$key', $key]
        ];

        $expires = '+5 minutes';

        $postObject = new PostObjectV4($client, $bucket, $formInputs, $options, $expires);

        $formAttributes = $postObject->getFormAttributes();

        $formInputs = $postObject->getFormInputs();


        return view('pictures.create', ['s3attributes' => $formAttributes,
            's3inputs' => $formInputs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PictureRequest $request)
    {
        $picture = new Picture;
        $picture->fill($request->all());
        $picture->save();
        return redirect()->route("pictures.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Picture $picture)
    {
        if(Str::startsWith($request->header('Accept'),"image")){
            return redirect(Storage::disk('s3')->temporaryUrl($picture->storage_path, now()->addMinutes(1)));
        }

        return view('pictures.show', compact('picture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        Storage::disk('s3')->delete($picture->storage_path);
        $picture->delete();

        return redirect()->route("pictures.index");
    }
}
