<?php

namespace App\Http\Controllers\Setup;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SetupController extends Controller
{
    protected array $dbConfig;

    public function __construct()
    {
        set_time_limit(8000000);
    }

    /**
     * This function is used to display the index of setup
     * @method GET /setup/start/
     * @return Renderable
     */

    public function index()
    {
        return view('setup.index');
    }

    /**
     * This function is used to check for the minimum requirements
     * @method GET /setup/requirements/
     * @return Renderable
     */

    public function requirements()
    {
        [$checks, $success] = $this->checkMinimumRequirements();
        return view('setup.requirements', compact('checks', 'success'));
    }

    /**
     * This function is used to check for the minimum requirements
     * @return Array
     */

    public function checkMinimumRequirements()
    {
        $checks = [
            'php_version' => PHP_VERSION_ID >= 70400,
            'extension_bcmath' => extension_loaded('bcmath'),
            'extension_ctype' => extension_loaded('ctype'),
            'extension_json' => extension_loaded('json'),
            'extension_mbstring' => extension_loaded('mbstring'),
            'extension_openssl' => extension_loaded('openssl'),
            'extension_pdo_mysql' => extension_loaded('pdo_mysql'),
            'extension_tokenizer' => extension_loaded('tokenizer'),
            'extension_xml' => extension_loaded('xml'),
            'env_writable' => File::isWritable(base_path('.env')),
            'storage_writable' => File::isWritable(storage_path()) && File::isWritable(storage_path('logs')),
        ];
        $success = (!in_array(false, $checks, true));
        return [$checks, $success];
    }

    /**
     * This function is used to return the view of database setup
     * @method GET /setup/database/
     * @return Renderable
     */

    public function database()
    {
        return view('setup.database');
    }

    /**
     * This function is used to accept the database submitted values and use them accordingly
     * @method POST /setup/database-submit/
     * @param Request
     * @return Renderable
     */
    public function databaseSubmit(Request $request)
    {
        try {
            $request->validate([
                'host' => 'required|ip',
                'port' => 'required|integer',
                'database' => 'required',
                'user' => 'required',
            ]);
            $this->createDatabaseConnection($request->all());
            $migration = $this->runDatabaseMigration();
            if ($migration !== true) {
                return redirect()->back()->withInput()->withErrors([$migration]);
            }
            $this->changeEnvDatabaseConfig($request->all());
            User::create([
                'name' => 'maher',
                'email' => 'maherfared@gmail.com',
                'password' => '12345678'
            ]);
            return view('setup.account');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * This function is used to create a database connection
     * @param Array of User Submitted Details Of Database
     * @return Response
     */
    public function createDatabaseConnection($details)
    {
        Artisan::call('config:clear');
        $this->dbConfig = config('database.connections.mysql');
        $this->dbConfig['host'] = $details['host'];
        $this->dbConfig['port'] = $details['port'];
        $this->dbConfig['database'] = $details['database'];
        $this->dbConfig['username'] = $details['user'];
        $this->dbConfig['password'] = $details['password'];
        Config::set('database.connections.setup', $this->dbConfig);
    }

    /**
     * This function is used to run the database migration
     */

    public function runDatabaseMigration()
    {
        try {
            Artisan::call('migrate:fresh', [
                '--database' => 'setup',
                '--force' => 'true',
                '--no-interaction' => true,
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

        /**
     * This function is used to change the Database Config In ENV File
    */

    public function changeEnvDatabaseConfig($config)
    {
        $this->changeEnvValues('DB_HOST', $config['host']);
        $this->changeEnvValues('DB_PORT', $config['port']);
        $this->changeEnvValues('DB_DATABASE', $config['database']);
        $this->changeEnvValues('DB_USERNAME', $config['user']);
        $this->changeEnvValues('DB_PASSWORD', $config['password']);
    }


    /**
     * This function is used to change the ENV Values
     */

    private function changeEnvValues($key, $value)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

        /**
     * This function is used to print the setup complete View
     * @return Renderable
     * @method GET /setup/complete/
     */

    public function setupComplete()
    {
        try{
           $setupStage = Configuration::where('config', 'setup_stage')->firstOrFail();
           if($setupStage['value'] != '3'){
               return redirect()->back()->withInput()->withErrors(['errors' => 'Setup Is Incomplete']);
           }
           $setupStage->update(['value' => '4']);
           Configuration::where('config', 'setup_complete')->firstOrFail()->update(['value' => '1']);
           return view('setup.complete');
        }catch(Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
