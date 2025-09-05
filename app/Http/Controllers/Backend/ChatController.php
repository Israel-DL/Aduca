<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    //
    public function SendMessage(Request $request)
    {
        $request->validate([
            'msg' => 'required',
        ]);

        ChatMessage::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->msg,
            'created_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Message sent successfully']);
    }

    public function GetAllUsers(){

        $chats = ChatMessage::orderBy('id','DESC')
                 ->where('sender_id',auth()->id())
                 ->orWhere('receiver_id',auth()->id())   
                 ->get();

        $users = $chats->flatMap(function($chat){
            if ($chat->sender_id === auth()->id()) {
                # code...
                return [$chat->sender, $chat->receiver];
            }
            return [$chat->receiver, $chat->sender];
        })->unique();

        return $users;
    }

    public function UserMsgById($userId){

        $user = User::find($userId);

        if ($user) {
            # code...
            $messages = ChatMessage::where(function($q) use ($userId){
                $q->where('sender_id',auth()->id());
                $q->where('receiver_id',$userId);
            })->orWhere(function($q) use ($userId){
                $q->where('sender_id',$userId);
                $q->where('receiver_id',auth()->id());
            })->with('user')->get();

            return response()->json([
                'user' => $user,
                'messages' => $messages
            ]);
        }else{
            abort(404);
        }
    }
}
