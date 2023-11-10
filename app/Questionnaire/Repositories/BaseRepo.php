<?php

namespace App\Questionnaire\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BaseRepo
{
    protected function storeProcess(string $slug, string $systemPath, array $data = ['pdfFile', 'name']): array
    {
        ['name' => $name, 'pdfFile' => $pdf] = $data;
        $pdfName = sprintf('%s-%s-%s.%s', $slug, Str::slug($name), Str::random(), $pdf->extension());
        $pdf->move(storage_path($systemPath), $pdfName);

        return ['fileName' => $pdfName];
    }

    protected function storeImageProcess(string $slug, string $systemPath, array $data = ['name', 'image_path']): array
    {
        ['name' => $name, 'image_path' => $image] = $data;
        $imageName = sprintf('%s-%s-%s.%s', $slug, Str::slug($name), Str::random(), $image->extension());
        $image->move(storage_path($systemPath), $imageName);

        return ['fileName' => $imageName];
    }

    protected function deleteProcess(Model $model, string $systemPath): bool
    {
        $filePath = sprintf('%s/%s', $systemPath, $model->getAttribute('material'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }

        return true;
    }

    protected function deleteImageProcess(Model $model, string $systemPath): bool
    {
        $filePath = sprintf('%s/%s', $systemPath, $model->getAttribute('image_path'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }

        return true;
    }
}
