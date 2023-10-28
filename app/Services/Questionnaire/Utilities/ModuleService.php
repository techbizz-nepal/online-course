<?php

namespace App\Services\Questionnaire\Utilities;


use App\DTO\Questionnaire\ModuleData;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleService extends BaseService implements InterfaceModuleService
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
        return $this->storeProcess(
            request: $request,
            slug: $assessment->getAttribute('slug'),
            systemPath: ModuleData::SYSTEM_PATH);
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
