<div class="main-content pt-lg-4">
    <h2 class="m-2 mb-0 d-flex justify-content-between">
        <span>Add New {{$label}}</span>
    </h2>
    <div class="w-100 h-100 bg-white mx-2 p-2">
        <form
            action="{{ route('admin.courses.assessments.modules.questions.store', $params) }}"
            method="POST"
            id="questionForm">
            @csrf
            @include($viewName, $params)
            <div class="row">
                <div class="col-md-12 text-left">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('admin.courses.assessments.modules.show', collect($params)->except(['type'])->toArray()) }}"
                       class="btn btn-primary"
                       type="submit">Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
