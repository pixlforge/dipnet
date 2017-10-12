<?php

namespace App\Http\Controllers\Profiles;

use App\Avatar;
use App\Http\Requests\Profile\AvatarUploadRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;

class AvatarController extends Controller
{
    protected $imageManager;

    /**
     * AvatarController constructor.
     *
     * @param $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function store(AvatarUploadRequest $request)
    {
        $processedImage = $this->imageManager->make($request->file('avatar')->getPathName())
            ->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('jpg')
            ->save(config('avatar.path.absolute') . $path = '/' . uniqid(true) . '.jpg');

        $avatar = Avatar::create([
            'path' => $path
        ]);

        return response([
            'id' => $avatar->id,
            'path' => $avatar->path()
        ], 200);
    }
}