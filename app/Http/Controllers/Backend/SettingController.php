<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;

class SettingController extends Controller
{
    //
    public function SmtpSetting(){

        $smtp = SmtpSetting::find(1);
        return view('admin.backend.setting.smtp_update',compact('smtp'));
    }// End method
}
