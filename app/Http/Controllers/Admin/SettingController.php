<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 1. Ye line add kijiye red underline hatane ke liye
use Illuminate\Support\Facades\Artisan; 

class SettingController extends Controller
{
    public function index() {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $secret = $request->maintenance_secret ?? 'admin-access';

        if ($request->has('maintenance_mode')) {
            // Site Down logic
            Artisan::call('down', [
                '--secret' => $secret,
                '--render' => 'errors.503'
            ]);
            $msg = "Site is now in Maintenance Mode.";
        } else {
            // Site Up logic
            Artisan::call('up');
            $msg = "Site is now Live.";
        }

        return back()->with('success', $msg);
    }
}