<?php

namespace App\Services\Questionnaire\Utilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BaseService
{
    protected function storeProcess(Request $request, string $slug, string $systemPath): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:10000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/'
        ]);
        ['name' => $name, 'pdfFile' => $pdf] = $data;
        $pdfName = sprintf('%s-%s-%s.%s', $slug, Str::slug($name), Str::random(), $pdf->extension());
        $pdf->move(storage_path($systemPath), $pdfName);
        return ['fileName' => $pdfName];
    }

    protected function deleteProcess(Model $model, string $systemPath): bool
    {
        $filePath = sprintf('%s/%s', $systemPath, $model->getAttribute('material'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }
        return true;
    }
}
