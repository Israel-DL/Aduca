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

    public function UpdateSmtp(Request $request){


        $smtp_id = $request->id;

        SmtpSetting::find($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);

        $notification = array(
            'message' => 'SMTP Setting Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification); 
    }// End Method
}
