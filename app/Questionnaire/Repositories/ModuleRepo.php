<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\ModuleData;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleRepo extends BaseRepo implements InterfaceModuleRepo
{
    public function create(ModuleData $moduleData, Assessment $assessment): Model
    {
        return $assessment->modules()->create($moduleData->toArray());
    }

    public function update(Assessment $assessment, ModuleData $moduleData): int
    {
        return $assessment->modules()->update($moduleData->toArray());
    }

    public function uploadMaterial(Request $request, Assessment $assessment): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:10000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/',
        ]);

        return $this->storeProcess(
            slug: $assessment->getAttribute('slug'),
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
