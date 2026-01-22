<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // get active notifications
    public function activeNotificationsList(Request $request) {
        try {
            $notifications = Notification::where('is_read', 0)->get();
            return ResponseHelper::Out('success', 'Order list retrieved successfully', $notifications, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| NotificationController--activeNotificationsList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }// get five notifications
    public function fiveNotificationsList(Request $request) {
        try {
            $notifications = Notification::where('is_read', 1)->limit(5)->get();
            return ResponseHelper::Out('success', 'Order list retrieved successfully', $notifications, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| NotificationController--fiveNotificationsList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // update notification status
    public function activeNotificationMarkAllRead(Request $request) {
        try {
            $notifications = Notification::where('is_read', 0)->get();
            foreach ($notifications as $notification) {
                $notification->is_read = 1;
                $notification->save();
            }
            return ResponseHelper::Out('success', 'Notification status updated successfully', 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| NotificationController--activeNotificationMarkAllRead ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
