<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chat;
use App\Events\ChatEvent;
use App\Events\MessageEvent;
use App\Models\Group;
use App\Models\group_participant;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index($id)
    {
      $my_id = Auth::id();
      $g = Group::where(['id' => $id])->where(['admin_id' => $my_id])->get();
      $go = Group::where(['id' => $id])->first();
      $r= Group::where(['id' => $id])->get();
      // if has this id in Group table reload page according id
      if($go){
         // if this user has a owner Group after reload page, get all his Group data to delete 
        if($g){
            return view('chat.chat',compact('g','r'));
            // if Group table doesnt have any Group in table open home page
        }if(!$g){
            return redirect()->route('home')
                            ->with('success','Your Group deleted, choose another Group Please');
          }
          // if doesnt have this id in Group table, page open home page
      }if(!$go){
        return redirect()->route('home')
        ->with('success','Your Group deleted choose another Group Please');
       }
      }
	  
	  public function subscribe()
    {
        $groupALL = Group::all();
        
        return view('group.join', compact('groupALL'));
    }
    
      // get all Messages from Chat table in database
    public function fetchAllMessages($id)
    {
        $group = Group::find($id);
        $my_id = Auth::id();
        // get all data from Chat table according id
        return Chat::where(['user_id' => $my_id])->where(['group_id' => $group->id])->get();
       
    }
    
    // send Messages to store and other Users who joined this Group
    public function sendMessage(Request $request, $id)
    {
        // for each MESSAGE i make a code, because when use wants delete each message can do it by code
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($characters), rand(0, 9), 7);
        $group = Group::find($id);
        // find all fans of this Group
        $r= group_participant::where(['group_id' => $group->id])->get();
        // send Messagge to each user
        foreach($r as $value) {
        $chat=chat::create([
            'date' => $request->date,
            'user_id' => $value->user_id,
            'fromm' => $request->fromm,
            'fromName' => auth()->user()->name,
            'code' => $code,
            'message' => $request->message,
            'group_id' => $id,
        ]);
        // after store in table of Chat, send this message one by one to other user by Pusher
        broadcast(new ChatEvent($chat->load('user')))->toOthers();
    }

        return ['status' => 'success'];
    }

    // delete or remove each Message
    public function destroy(Request $request, $code)
    {
        $chat=chat::where(['code' => $request->code])->delete();
        return response()->json('users deleted');
    }


    /// delete or remove all a Group from table with fans and chats
    public function delete(Request $request, $id)
    {
        $chat=Group::where(['id' => $id])->delete();
        $r= group_participant::where(['group_id' => $id])->delete();
        $chat= chat::where(['group_id' => $id])->delete();
        return redirect()->route('home')
                        ->with('success','Your Group deleted successfully');
    }
}