<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
use Illuminate\Support\Facades\Storage;
use service\Export\ExporterInterface;
use service\Export\MarkdownExporter;
use service\Export\TextExporter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
