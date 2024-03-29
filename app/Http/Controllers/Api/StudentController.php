<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        if($students->count()>0){
            $data = [
                'status'=> 200,
                'students'=> $students,
            ];
            return response()->json($data,200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'no record found',
            ],404);
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|digits:10',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $student = Student::create([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'phone'=> $request->phone
            ]);
            if($student){
                return response()->json([
                    'status'=> 200,
                    'message'=>'student succefully created'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'something went wrong'
                ],500);
            }
        }
    }
    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=> 200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Student found'
            ],404);
        }
    }
    public function edit(Request $request,$id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=> 200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Student found'
            ],404);
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|digits:10',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $student = Student::find($id);
            $student->update([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'phone'=> $request->phone
            ]);
            if($student){
                return response()->json([
                    'status'=> 200,
                    'message'=>'student succefully updated'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'something went wrong for update'
                ],500);
            }
        }
    }
    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=> 200,
                'message'=>'Student deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Student found'
            ],404);
        }

    }
}
