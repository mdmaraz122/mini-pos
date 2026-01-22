<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // settings update
    public function SettingUpdate(Request $request) {
        try {
            Setting::where('id', 1)->update([
                'shop_name' => CustomSanitize::sanitize($request->input('name')),
                'shop_address' => CustomSanitize::sanitize($request->input('address')),
                'shop_phone' => CustomSanitize::sanitize($request->input('phone')),
                'receipt_message' => CustomSanitize::sanitize($request->input('ReceiptMessage')),
            ]);
            return ResponseHelper::Out('success', 'Setting created successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| SettingController--SettingUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // get settings
    public function getSetting(Request $request) {
        try {
            $data = Setting::where('id', 1)->first();
            return ResponseHelper::Out('success', 'Setting created successfully', $data, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| SettingController--getSetting ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // backup generate
    public function BackupGenerate(Request $request)
    {
        try {
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbUsername = env('DB_USERNAME', 'root');
            $dbPassword = env('DB_PASSWORD', '');
            $dbName = env('DB_DATABASE');

            $fileName = "backup_" . now()->format('Y_m_d_H_i_s') . ".sql";
            $backupPath = storage_path("app/backup");
            $backupFile = "{$backupPath}\\{$fileName}";

            // Ensure the directory exists
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';

            // Windows-safe command
            $command = "\"{$mysqldumpPath}\" -h {$dbHost} -u {$dbUsername} -p\"{$dbPassword}\" {$dbName} > \"{$backupFile}\"";

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                logger()->error("Backup failed. Command: $command \nOutput: " . implode("\n", $output));
                return ResponseHelper::Out('error', 'Backup failed. Check logs for details.', null, 200);
            }

            return ResponseHelper::Out('success', 'Backup generated successfully at: ' . $backupFile, null, 200);

        } catch (Exception $e) {
            logger()->error(now() . ' ||| SettingController--BackupGenerate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong: ' . $e->getMessage(), null, 200);
        }
    }


}
