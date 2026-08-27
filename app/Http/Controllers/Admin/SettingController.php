<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display the settings edit form.
     *
     * @return \Illuminate\View\View
     */
     public function edit()
    {
        // Logic to retrieve existing settings from the database
        // and pass them to the view.
        // For example:
        $settings = Setting::pluck('value', 'name')->all(); // Assuming settings are key-value pairs
    
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update the settings in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the request data.
        $request->validate([
        ]);

        // Handle site logo upload if present
        

        // Handle other settings fields
        $data = $request->except(['site_logo', '_token']);
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value); // Convert arrays to JSON strings
            }
            if ($value === null) {
                $value = ''; // Store null values as empty strings

            }
            Setting::updateOrCreate(['name' => $key], ['value' => $value]);
        }
        if ($request->hasFile('site_logo')) {
            $imageName = time().'.'.$request->site_logo->extension();  
            $request->site_logo->move(public_path('images'), $imageName); // Store in public/images
            Setting::updateOrCreate(['name' => 'site_logo'], ['value' => $imageName]);
        }

        \Cache::forget('settings');

        if (isset($data['min_d'])) {
            \App\Models\Configure::where('id', 1)->update(['min_d' => $data['min_d']]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}

