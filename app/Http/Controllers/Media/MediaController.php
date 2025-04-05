<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MediaStoreRequest;
use App\Http\Requests\Media\MediaUpdateRequest;
use Illuminate\Http\Request;
use App\Services\Media\MediaService;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        return responseHelper($this->mediaService->getAllMedia());
    }

    public function show($id)
    {
        return responseHelper($this->mediaService->getMediaById($id));
    }

    public function store(MediaStoreRequest $request)
    {
        return responseHelper($this->mediaService->createMedia($request->all()));
    }

    public function update(MediaUpdateRequest $request, $id)
    {
        return responseHelper($this->mediaService->updateMedia($id, $request->all()));
    }

    public function destroy($id)
    {
        return responseHelper($this->mediaService->deleteMedia($id));
    }
}
