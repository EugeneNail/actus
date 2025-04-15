<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportDiariesRequest;
use App\Http\Requests\ExportPhotosRequest;
use App\Services\Export\DiaryExporter;
use App\Services\Export\PhotoExporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExportController extends Controller
{
    private DiaryExporter $diaryExporter;

    private PhotoExporter $photoExporter;


    public function __construct(DiaryExporter $diaryExporter, PhotoExporter $photoExporter)
    {
        $this->diaryExporter = $diaryExporter;
        $this->photoExporter = $photoExporter;
    }


    public function diaries(ExportDiariesRequest $request)
    {
        [$path, $name] = $this->diaryExporter->export($request->user(), $request->year);

        return response()
            ->download($path, $name)
            ->deleteFileAfterSend();
    }


    public function photos(ExportPhotosRequest $request)
    {
        [$path, $name] = $this->photoExporter->export($request->user(), $request->year, $request->month);

        if (!File::exists($path)) {
            return redirect(route('menu.index'));
        }

        return response()->download($path, $name);
    }
}
