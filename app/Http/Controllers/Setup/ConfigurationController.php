<?php

namespace App\Http\Controllers\Setup;
use Exception;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
     /**
     * This function is used to return View of Configuration
     * @method GET /setup/configuration/
     * @return Renderable
     */

     public function configuration()
     {
         return view('setup.config');
     }

     /**
      * This function is used to save the configuration values in the database
      * @param Request
      * @return Renderable
      * @method POST /setup/configuration-submit/
      */

    public function configurationSubmit(Request $request)
    {
        try{
            $configurations = $this->processInputs($request);
            $configurations['setup_stage'] = '3';
            foreach($configurations as $key => $config){
                Configuration::updateOrCreate(
                    [
                      'config' => $key
                    ],
                    [
                      'value' => $config
                    ]
                  );
            }
            return redirect()->route('setup.complete');
        }catch(Exception $e){
            return redirect()->route('setup.configuration')->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * This function is used to process the inputs
     * It makes the validation first and saves the images etc. to desired path
     * @param Array
     * @return Array
     */

    public function processInputs($request)
    {
        $validated = $this->validateInput($request);
        $logo = saveImage($validated['config_app_logo'], 'img');
        $favicon = saveImage($validated['config_app_favicon_icon'], 'img');
        $validated['config_app_logo'] = $logo;
        $validated['config_app_favicon_icon'] = $favicon;
        return $validated;
    }



    /**
     * This function is used to validate the config submitted input values
     * @param Array
     * @return Array
     */

     public function validateInput($request)
     {
         return $request->validate([
             'config_company_name' => 'required',
             'config_company_address' => 'required',
             'config_app_name' => 'required',
             'config_app_currency' => 'required|in:INR',
             'config_app_lang' => 'required|in:en',
             'config_app_logo' => 'required|max:2048|mimes:png,jpeg,jpg,ico,gif',
             'config_app_favicon_icon' => 'required|max:2048|mimes:png,jpeg,jpg,ico,gif',
             'config_app_timestamp' => 'required|in:Asia/Kolkata',
             'config_color_scheme_class' => 'required|in:bg-primary',
             'config_right_footer_1' => 'required',
             'config_right_footer_2' => 'required',
             'config_left_footer_1' => 'required',
             'config_left_footer_2' => 'required',
             'config_is_footer_fixed' => 'required|in:fixed-footer',
             'config_is_header_fixed' => 'required|in:fixed-header',
             'config_is_sidebar_fixed' => 'required|in:fixed-sidebar',
             'config_is_checked_notification' => 'required|in:fixed-notification',
             'config_mail_mailer' => 'required|in:smtp',
             'config_mail_host' => 'required',
             'config_mail_port' => 'required|integer',
             'config_mail_encryption' => 'required',
             'config_mail_username' => 'required',
             'config_mail_password' => 'required',
             'config_mail_from' => 'required|email',
         ]);
     }
}
