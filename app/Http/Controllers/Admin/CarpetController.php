<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarpetRequest;
use App\Http\Requests\StoreCarpetRequest;
use App\Http\Requests\UpdateCarpetRequest;
use App\Models\Carpet;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CarpetController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('carpet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpets = Carpet::with(['media'])->get();

        return view('admin.carpets.index', compact('carpets'));
    }

    public function create()
    {
        abort_if(Gate::denies('carpet_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carpets.create');
    }

    public function store(StoreCarpetRequest $request)
    {
        $carpet = Carpet::create($request->all());

        if ($request->input('image', false)) {
            $carpet->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carpet->id]);
        }

        return redirect()->route('admin.carpets.index');
    }

    public function edit(Carpet $carpet)
    {
        abort_if(Gate::denies('carpet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carpets.edit', compact('carpet'));
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

        return redirect()->route('admin.carpets.index');
    }

    public function show(Carpet $carpet)
    {
        abort_if(Gate::denies('carpet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carpets.show', compact('carpet'));
    }

    public function destroy(Carpet $carpet)
    {
        abort_if(Gate::denies('carpet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpet->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarpetRequest $request)
    {
        Carpet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('carpet_create') && Gate::denies('carpet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Carpet();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
