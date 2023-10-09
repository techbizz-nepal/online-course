<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BannerController extends Controller
{

    public function index()
    {
        $banner = Banner::first();
        return view('admin.banners.index', compact('banner'));
    }

    public function create()
    {
        abort('404');
        // return view('admin.banners.create');
    }
    
    public function store(Request $request)
    {
        abort('404');    
    }
    
    public function show(Banner $banner)
    {
        return redirect()->route('admin.banner.index');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'banner_text' => 'required | max: 2000',
            'banner_image' => 'image | max: 2048',
        ]);
        DB::beginTransaction();
        try {
            if ($request->has('banner_image')){
                $image = $request->file('banner_image');
                $imageName = 'banner-'.uniqid().'.'.$image->extension();
                $image->move(public_path('storage/images/banners'), $imageName);
                $data['banner_image'] = $imageName;
            }

            $banner->update($data);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->withErrors('Failed to edit banner');
        }
        return redirect()->route('admin.banner.index')->with('success', 'Banner Updated Successfully.');
    }

    public function destroy(Course $course)
    {
        abort('404');
    }
}
