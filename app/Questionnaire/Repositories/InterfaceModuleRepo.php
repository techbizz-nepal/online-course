<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\ModuleData;
use App\Models\Course;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceModuleRepo
{
    public function create(ModuleData $moduleData, Course $course): Model;

    public function update(Course $course, ModuleData $moduleData): int;

    public function uploadMaterial(Request $request, Course $course): array;

    public function deleteMaterial(Module $module): bool;

    public function getOrGenerateSlug(ModuleData $moduleData, Module $module): string;
}
