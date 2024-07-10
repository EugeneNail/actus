<?php

namespace App\Http\Controllers;

use App\Services\Export\MarkdownExporter;
use App\Services\Export\PhotoExporter;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    private MarkdownExporter $markdownExporter;

    private PhotoExporter $photoExporter;


    public function __construct(MarkdownExporter $markdownExporter, PhotoExporter $photoExporter)
    {
        $this->markdownExporter = $markdownExporter;
        $this->photoExporter = $photoExporter;
    }


    public function diaries(Request $request)
    {
        [$path, $name] = $this->markdownExporter->export($request->user());

        return response()
            ->download($path, $name)
            ->deleteFileAfterSend();
    }


    public function photos(Request $request)
    {
        [$path, $name] = $this->photoExporter->export($request->user());

        return response()
            ->download($path, $name)
            ->deleteFileAfterSend();
    }
}
