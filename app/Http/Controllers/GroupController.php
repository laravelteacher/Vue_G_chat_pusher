<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;

class GroupController extends Controller  
{
    public function __construct()
    {
        $this->middleware('auth');

        //some functions can only be executed by group admin/owner
        $this->middleware('owner')->only(['edit', 'update', 'delete', 'remove_user']);

        //the group will only be accessed by a member  message
        $this->middleware('member')->only('show');
    }

    //display form to create a group //-- show create Group Page
    public function create_form()
    {
        return view('group.create');
    }
    // create New Group
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        //generate a code for the groupe        
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($characters), rand(0, 9), 7);
       // insert New Group to Table
        $group = Group::create([
            'name' => $request->name,
            'code' => $code,
            'admin_id' => auth()->user()->id,
        ]);
        
        //we attach the user with the group after he created it
       $group->participants()->attach(auth()->user()->id);

        return redirect('/home')->with('success', 'Your group has been created');
    }

    //display the form to join a group
    public function join_form()
    {
        return view('group.join');
    }

    //user join a group by entering the code
    public function join(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code = $request->code;
       $group = Group::where('code', $code)->first();

        //if the group exists
        if ($group)
        {
            try 
            {
                //we add the user to the group and we redirect him to the home page with a success message
                $group->participants()->attach(auth()->user()->id);
                return redirect('/home')->with('success', 'Group joined');
            } 
            catch (\Throwable $th) 
            {
                //Display an error if the user is already in the group
                return redirect()->back()->with('error', 'You are already a member of this group');
            }
        }
        else
        {
            //if the group doesn't exist we throw an error
            return redirect()->back()->with('error', 'Group not found');
        }
    }
}