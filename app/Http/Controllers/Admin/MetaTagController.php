<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaTag;
use App\Models\Page;
use Illuminate\Http\Request;

class MetaTagController extends Controller
{
    public function index(){
        $metaTags = MetaTag::with('pages')->get();
        return view('admin.meta-tags.index', compact('metaTags'));
    }

    public function create(){
        $pages = Page::all();
        return view('admin.meta-tags.create', compact('pages'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'max: 100',
            'property' => 'max: 150',
            'content' => 'required | min: 1 | max: 1000',
            'pages' => 'required | array | min: 1'
        ]);
        $pages = $request->get('pages');
        $pageIDs = [];
        foreach ($pages as $page){
            $pageID = Page::where('slug', $page)->first()->id ?? null;
            if ($pageID === null){
                continue;
            }
            array_push($pageIDs, $pageID);
        }
        $metaTag = MetaTag::create([
            'name' => $request->get('name'),
            'property' => $request->get('property'),
            'content' => $request->get('content')
        ]);
        $metaTag->pages()->attach($pageIDs);
        return redirect()->route('admin.meta-tag.index')->with('success', 'Meta Tag Added Successfully.');
    }

    public function edit(MetaTag $metaTag){
        $pages = Page::all();
        return view('admin.meta-tags.edit', compact('pages', 'metaTag'));
    }

    public function update(Request $request, MetaTag $metaTag){
        $request->validate([
            'name' => 'max: 100',
            'property' => 'max: 150',
            'content' => 'required | min: 1 | max: 1000',
            'pages' => 'required | array | min: 1'
        ]);
        $pages = $request->get('pages');
        $pageIDs = [];
        foreach ($pages as $page){
            $pageID = Page::where('slug', $page)->first()->id ?? null;
            if ($pageID === null){
                continue;
            }
            array_push($pageIDs, $pageID);
        }
        $metaTag->update([
            'name' => $request->get('name'),
            'property' => $request->get('property'),
            'content' => $request->get('content')
        ]);
        $metaTag->pages()->sync($pageIDs);
        return redirect()->route('admin.meta-tag.index')->with('success', 'Meta Tag Updated Successfully.');
    }

    public function destroy(MetaTag $metaTag){
        $metaTag->delete();
        return redirect()->route('admin.meta-tag.index')->with('success', 'Meta Tag Updated Successfully.');
    }
}
