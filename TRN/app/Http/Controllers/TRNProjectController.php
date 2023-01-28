<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use App\Models\ProjectModel;
use DB;

class TRNProjectController extends Controller
{
    public function trnproject(){
        $contact=contacts::count();
        $viewcontact=contacts::orderBy('contact_id','desc')->take(4)->get();
        $countproject=ProjectModel::count();
        $activeproject=ProjectModel::where('status','In Progress')->count();
        $completeproject=ProjectModel::where('status','Completed')->count();
        $pendingproject=ProjectModel::where('status','Pending')->count();
        $table=DB::select(DB::raw("SELECT * FROM trnprojects;"));

        
        return view('home/trn_projects',compact('contact','viewcontact','table','countproject',
        'activeproject','completeproject','pendingproject'));
    }

    public function insertdata(Request $request){
        $request->validate(
            [
              'title'=>'required' , 
              'progress'=>'required',
              'status'=>'required',
              'priority'=>'required',
              'given'=>'required',
              'category'=>'required',
              'duedate'=>'required|date',
            ]
            );

        $project=new ProjectModel;
        $project->title=$request['title'];
        $project->progress=$request['progress'];
        $project->status=$request['status'];
        $project->priority=$request['priority'];
        $project->budget=$request['budget'];
        $project->givenby=$request['given'];
        $project->category=$request['category'];
        $project->duedate=$request['duedate'];
        $project->User_ID=$request['admin_id'];
        $project->save();
        if($project){
            return back()->with('success','The project details is saved successfully');
        }
        else{
            return back()->with('fail','Error Occurred');
        }
    }
}