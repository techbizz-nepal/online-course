<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page){
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page){
        $data = $request->validate([
           'title' => 'required | min: 1 | max: 250'
        ]);
        $page->update($data);
        return redirect()->route('admin.page.index')->with('success', "Page Updated Successfully.");
    }
}
