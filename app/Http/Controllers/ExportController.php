<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
use App\Services\Export\ExporterInterface;
use App\Services\Export\MarkdownExporter;
use service\Export\TextExporter;

class ExportController extends Controller
{
    /** @var $exporters array<string, ExporterInterface> */
    private array $exporters;


    public function __construct(MarkdownExporter $markdownExporter)
    {
        $this->exporters = [
            'diary' => $markdownExporter,
        ];
    }


    public function __invoke(ExportRequest $request)
    {
        [$path, $name] = $this->exporters[$request->target]->export($request->user());
        $path = storage_path("app/$path");

        return response()
            ->download($path, $name)
            ->deleteFileAfterSend();
    }
}
