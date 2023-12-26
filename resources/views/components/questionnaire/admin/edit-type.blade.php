<div class="main-content pt-lg-4">
    <h2 class="m-2 mb-0 d-flex justify-content-between">
        <span>Edit {{$label}}</span>
    </h2>
    <div class="w-100 h-100 bg-white mx-2 p-2">
        <form
            action="{{ route('admin.courses.modules.questions.update', $params) }}"
            method="POST"
            id="questionForm">
            @csrf
            @method('PATCH')
            @include($viewName, ['params' => $params, 'question' => $question, 'module' => $module])
            <div class="row mx-auto">
                <div class="col-md-12 text-left">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('admin.courses.modules.show', collect($params)->except(['type','question'])->toArray()) }}"
                       class="btn btn-primary"
                       type="submit">Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
