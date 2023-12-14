<?php

namespace App\Http\Controllers;

use App\Models\Connection as ConnectionModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class mainController extends Controller
{

    protected function authenticateUser($firstUser, $secondUser)
    {
        $isFirstUser = ConnectionModel::where('first_user', $firstUser)->Where('second_user', $secondUser)->first();
        if (!$isFirstUser) {
            $isSecondUser = ConnectionModel::where('second_user', $firstUser)->Where('first_user', $secondUser)->first();
            if (!$isSecondUser) {
                return false;
            } else {
                return true;
            }
        }
        return true;
    }

    protected function connectionId($firstUser, $secondUser)
    {
        $isFirstUser = ConnectionModel::where('first_user', $firstUser)->Where('second_user', $secondUser)->select('id')->first();
        if (!$isFirstUser) {
            $isSecondUser = ConnectionModel::where('second_user', $firstUser)->Where('first_user', $secondUser)->select('id')->first();
            if (!$isSecondUser) {
                return false;
            } else {
                return $isSecondUser->id;
            }
        }
        return $isFirstUser->id;
    }

    public function index()
    {
        $authUser = Auth::user();
        $connections = ConnectionModel::where('connections.first_user', $authUser->id)->orWhere('connections.second_user', $authUser->id)->where('connections.status', 'connected')->orderby('connected_from', 'ASC')->select('id', 'first_user', 'second_user', 'last_message')->get();
        // dd($connections->toArray());
        return view('home', compact('connections'));
    }

    // public function sendMsg(Request $request)
    // {
    //     $cleanContent = Purifier::clean($request->input('type_message'));
    //     $contentWithLineBreaks = nl2br($cleanContent);
    //     dd($contentWithLineBreaks);
    // }

    // public function userChats($username)
    // {
    //     try {
    //         $authUser = Auth::user();
    //     } catch (\Exception $err) {
    //         return redirect()->back()->with('error', 'Something went wrong. ' . $err);
    //     }
    // }

    public function getMessage($id, $username)
    {
        try {
            if ($id == 0) {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
            $authUser = Auth::user();

            if (!$this->authenticateUser($authUser->id, $id)) {
                return response()->json(['status' => false, 'message' => 'Sorry, You are not connected with ' . $username]);
            }

            //validation Passed Connected now retrive the message

            $authUserId = $authUser->id;

            $messages = Message::where(function ($query) use ($authUserId, $id) {
                $query->where('sender', $authUserId)
                    ->where('reciever', $id);
            })
                ->orWhere(function ($query) use ($authUserId, $id) {
                    $query->where('sender', $id)
                        ->where('reciever', $authUserId);
                })
                ->orderBy('time', 'ASC')
                ->get();

            Message::where('reciever', $authUserId)->update(['status' => 'seen']);

            $otherPersoDetails = User::where('id', $id)->select('id', 'name', 'profile_pic')->first();
            // dd($otherPersoDetails->toArray());
            $otherPersoneName = $otherPersoDetails->name;
            $dbImage = $otherPersoDetails->profile_pic;

            if ($dbImage == null || $dbImage == '' || empty($dbImage)) {
                $otherPersonImage = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
            } else {
                if (file_exists(asset('user_profile_picture/thumb/' . $dbImage))) {
                    $otherPersonImage = asset('user_profile_picture/thumb/' . $dbImage);
                } else {
                    $otherPersonImage = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
                }
            }

            $otherPersonImage = asset('user_profile_picture/thumb/' . $dbImage);
            $otherPersoneId = $otherPersoDetails->id;

            return view('chats', compact('messages', 'otherPersoneName', 'otherPersonImage', 'otherPersoneId'));
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }

    public function SendMessageAjax(Request $request)
    {
        try {

            $rules = [
                'id' => 'required|numeric',
                'message' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation Failed']);
            }

            $authUser = Auth::user();
            if (!$this->authenticateUser($authUser->id, $request->id)) {
                return response()->json(['status' => false, 'message' => 'Authentication Failed']);
            }

            // Authentication Passed Now Insert The Message

            $now = Carbon::now();
            $cleanContent = Purifier::clean($request->message);
            $message = nl2br($cleanContent);

            $msgId = DB::table('messages')->insertGetId([
                'message' => $message ?? 'Server Issue',
                'sender' =>  $authUser->id,
                'reciever' => $request->id,
                'status' => 'unseen',
                'time' => $now
            ]);

            $connectionId = $this->connectionId($authUser->id, $request->id);
            try {
                $connection = ConnectionModel::where('id', $connectionId)->first();
                $connection->last_message = $msgId;
                $connection->update();
            } catch (\Exception $err) {
                dd($err);
            }
            return response()->json(['status' => true, 'time' => Carbon::parse($now)->format('h:iA'), 'message' => $message]);
        } catch (\Exception $err) {
            dd($err);
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }

    public function getMessageRealtime($id, $username)
    {
        try {
            if ($id == 0 || $id == '') {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
            $authUser = Auth::user();

            if (!$this->authenticateUser($authUser->id, $id)) {
                return response()->json(['status' => false, 'message' => 'Sorry, You are not connected with ' . $username]);
            }

            //validation Passed Connected now retrive the message
            $authUserId = $authUser->id;
            $messages = Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->get();
            Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->update(['status' => 'seen']);
            return view('realtime-chats', compact('messages'));
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }
}
