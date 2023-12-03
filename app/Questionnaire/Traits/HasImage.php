<?php

namespace App\Questionnaire\Traits;

use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasImage
{
    public function uploadSingleImage(array $data, Module $module, string $systemPath): array
    {
        ['name' => $name, 'image_path' => $image] = $data;
        $imageName = sprintf('%s-%s-%s.%s', $module->getAttribute('slug'), Str::slug($name), Str::random(), $image->extension());
        $image->move(storage_path($systemPath), $imageName);

        return ['fileName' => $imageName];
    }

    public function deleteSingleImage(Question $question, string $systemPath): void
    {
        $filePath = sprintf('%s/%s', $systemPath, $question->getAttribute('image_path'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }
    }
}
