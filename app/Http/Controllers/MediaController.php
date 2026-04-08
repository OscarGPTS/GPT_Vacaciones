<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Download a media file
     *
     * @param Media $mediaItem
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Media $mediaItem)
    {
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }
}
