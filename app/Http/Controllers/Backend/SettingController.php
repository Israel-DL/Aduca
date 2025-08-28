<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    public function SiteSetting(){

        $site = SiteSetting::find(1);
        return view('admin.backend.setting.site_update',compact('site'));
    }

    public function UpdateSite(Request $request){

        $site_id = $request->id;

        if ($request->file('logo')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('logo')->getClientOriginalExtension();

            $img = $manager->read($request->file('logo'));
            $img = $img->resize(140,41);

            $img->toJpeg(80)->save(base_path('public/upload/logo/'.$name_gen));
            $save_url = 'upload/logo/'.$name_gen;

            SiteSetting::find($site_id)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);//End If Conditon  

            $notification = array(
                'message' => 'Site Settings Updated with image Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }else{

            SiteSetting::find($site_id)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'copyright' => $request->copyright,
            ]);//End If Conditon    

            $notification = array(
                'message' => 'Site Settings Updated without image Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }//End Else Statement
    }

}
