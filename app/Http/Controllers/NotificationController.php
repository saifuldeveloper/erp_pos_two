<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SendNotification;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use Spatie\Permission\Models\Role;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_permission:all_notification')->only('index');
    }

    public function index()
    {
        $lims_notification_all = DB::table('notifications')->get();
        return view('backend.notification.index', compact('lims_notification_all'));
    }
    public function store(Request $request)
    {
        $document = $request->document;
        if($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = date('Ymdhis').'.'.$document->getClientOriginalExtension();
            $document->move('public/documents/notification', $documentName);
            $request->document_name = $documentName;
        }
    	$user = User::find($request->receiver_id);
    	$user->notify(new SendNotification($request));
    	return redirect()->back()->with('message', 'Notification send successfully');
    }

    public function markAsRead()
    {
    	Auth::user()->unreadNotifications->where('data.reminder_date', date('Y-m-d'))->markAsRead();
    }
}
