<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait HasRedirectResponse
{

    public function successRedirectWithParamsResponse(string $routeName, array $routeParams, string $translationKey): RedirectResponse
    {
        return redirect()
            ->route($routeName, $routeParams)
            ->with('success', __(key: $translationKey));
    }

    public function successRedirectResponse(string $translationKey): RedirectResponse
    {
        return redirect()->back()->with('success', __($translationKey));
    }

    public function failureRedirectWithInputResponse(string $translationKey, array $inputArray): RedirectResponse
    {
        return back()
            ->withErrors(['errors' => __(key: $translationKey)])
            ->withInput($inputArray);
    }

    public function failureRedirectResponse(string $translationKey): RedirectResponse
    {
        return back()
            ->withErrors(['errors' => __(key: $translationKey)]);
    }
}
