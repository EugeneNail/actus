<?php

namespace App\Http\Controllers;

use App\Http\Requests\Photo\StoreRequest;
use App\Models\Photo;
use App\Services\Photo\PhotoServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{
    private PhotoServiceInterface $service;


    public function __construct(PhotoServiceInterface $service)
    {
        $this->service = $service;
    }


    public function store(StoreRequest $request): JsonResponse
    {
        $photos = $request->file('photos');
        $names = $this->service->saveMany($photos, $request->user()->id);

        return response()->json($names, Response::HTTP_CREATED);
    }


    public function show(Request $request, string $name): BinaryFileResponse
    {
        $isPhotoValid = $this->service->isOwned($name, $request->user()->id)
            && $this->service->exists($name);
        if (!$isPhotoValid) {
            abort(404);
        }

        return response()->file(storage_path("app/photos/$name"));
    }


    public function destroy(Request $request, string $name): Response
    {
        $isPhotoValid = $this->service->isOwned($name, $request->user()->id)
            && $this->service->exists($name);
        if (!$isPhotoValid) {
            abort(404);
        }

        $this->service->destroy($name);

        return response()->noContent();
    }
}
