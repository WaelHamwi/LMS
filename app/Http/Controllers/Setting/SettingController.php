<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Helpers\Upload\UploadHelper;


class SettingController extends Controller
{
    public function show()
    {
        $settings = \DB::table('settings')->pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }


    public function update(Request $request)
    {
        try {
            $info = $request->except('_token', '_method', 'logo');
            foreach ($info as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }

            if ($request->hasFile('logo')) {
                $logo_name = $request->file('logo')->getClientOriginalName();
                Setting::where('key', 'logo')->update(['value' => $logo_name]);
                UploadHelper::uploadFile($request, 'logo', 'logo');
            }
            if ($request->hasFile('favicon')) {
                $favicon_name = $request->file('favicon')->getClientOriginalName();
                Setting::where('key', 'favicon')->update(['value' => $favicon_name]);
                UploadHelper::uploadFile($request, 'favicon', 'favicon'); 
            }

            return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
