<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\ModuleData;
use App\Models\Course;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleRepo extends BaseRepo implements InterfaceModuleRepo
{
    public function create(ModuleData $moduleData, Course $course): Model
    {
        return $course->modules()->create($moduleData->toArray());
    }

    public function update(Course $course, ModuleData $moduleData): int
    {
        return $course->modules()->update($moduleData->toArray());
    }

    public function uploadMaterial(Request $request, Course $course): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:20000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/',
        ]);

        return $this->storeProcess(
            slug: $course->getAttribute('slug'),
            systemPath: ModuleData::SYSTEM_PATH,
            data: $data
        );
    }

    public function deleteMaterial(Module $module): bool
    {
        return $this->deleteProcess(model: $module, systemPath: ModuleData::SYSTEM_PATH);
    }

    public function getOrGenerateSlug(ModuleData $moduleData, Module $module): string
    {
        return $module->query()->where('slug', $moduleData->slug)->exists()
            ? sprintf('%s-%s', $moduleData->slug, Str::random(10))
            : $moduleData->slug;
    }
}
