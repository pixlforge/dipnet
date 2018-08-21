<?php

namespace App\Http\Controllers\Admin\Order;

use App\Order;
use Spatie\MediaLibrary\MediaStream;
use App\Http\Controllers\Controller;

class OrderFileDownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function download(Order $order)
    {
        $documents = $order->documents()->with('media')->get();

        $media = [];
        
        foreach ($documents as $document) {
            array_push($media, $document->media->first());
        }

        return MediaStream::create('commande-' . $order->reference . '-fichiers.zip')->addMedia($media);
    }
}
