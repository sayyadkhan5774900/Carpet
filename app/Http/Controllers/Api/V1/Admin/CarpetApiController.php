<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarpetRequest;
use App\Http\Requests\UpdateCarpetRequest;
use App\Http\Resources\Admin\CarpetResource;
use App\Models\Carpet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarpetApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('carpet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarpetResource(Carpet::all());
    }

    public function store(StoreCarpetRequest $request)
    {
        $carpet = Carpet::create($request->all());

        if ($request->input('image', false)) {
            $carpet->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CarpetResource($carpet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Carpet $carpet)
    {
        abort_if(Gate::denies('carpet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarpetResource($carpet);
    }

    public function update(UpdateCarpetRequest $request, Carpet $carpet)
    {
        $carpet->update($request->all());

        if ($request->input('image', false)) {
            if (!$carpet->image || $request->input('image') !== $carpet->image->file_name) {
                if ($carpet->image) {
                    $carpet->image->delete();
                }
                $carpet->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($carpet->image) {
            $carpet->image->delete();
        }

        return (new CarpetResource($carpet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Carpet $carpet)
    {
        abort_if(Gate::denies('carpet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
