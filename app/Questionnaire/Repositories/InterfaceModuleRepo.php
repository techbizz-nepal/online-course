<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\ModuleData;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceModuleRepo
{
    public function create(ModuleData $moduleData, Assessment $assessment): Model;

    public function update(Assessment $assessment, ModuleData $moduleData): int;

    public function uploadMaterial(Request $request, Assessment $assessment): array;

    public function deleteMaterial(Module $module): bool;

    public function getOrGenerateSlug(ModuleData $moduleData, Module $module): string;
}
