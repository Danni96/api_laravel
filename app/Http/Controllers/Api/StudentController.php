<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $Students = Student::all();

        // if($Students->isEmpty()) {
        //     $data = [
        //         'status' => 200,
        //         'message' => 'no se encontro estudiantes'
        //     ];
        // }

        $data = [
           'status' => 200,
            'students' => $Students
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:student',
                'phone' => 'required|digits:8',
                'language' => 'required|in:English,Spanish,French,German,Russian',
        ]);
        
        if($validator->fails()) {
            $data = [
               'message' => 'Error en la validación de los datos',
               'status' => 400,
               'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);
    
        if(!$student){
            $data = [
               'message' => 'Error al crear el estudiante',
               'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
           'message' => 'Estudiante creado correctamente',
           'status' => 201,
           'student' => $student
        ];
        return response()->json($data, 201);
    }


    public function show($id){
        $student = Student::find($id);

        if(!$student){
            $data = [
               'message' => 'No se encontro el estudiante',
               'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
           'status' => 200,
           'student' => $student
        ];
        return response()->json($data, 200);

    }

    public function destroy($id){
        $student = Student::find($id);

        if(!$student){
            $data = [
               'message' => 'No se encontro el estudiante',
               'status' => 404
            ];

            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
           'message' => 'Estudiante eliminado correctamente',
           'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data = [
               'message' => 'No se encontro el estudiante',
               'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required|email',
            'phone' =>'required|digits:8',
            'language' =>'required|in:English,Spanish,French,German,Russian',
        ]);
        
        if($validator->fails()) {
            $data = [
               'message' => 'Error en la validación de los datos',
               'status' => 400,
               'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        }     

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->save();

        $data = [
           'message' => 'Estudiante actualizado correctamente',
           'status' => 200,
           'student' => $student
        ];
        return response()->json($data, 200);
    }

    public function updateParcial(Request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data = [
               'message' => 'No se encontro el estudiante',
               'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'name' =>'max:255',
            'email' =>'email',
            'phone' =>'digits:8',
            'language' =>'in:English,Spanish,French,German,Russian',
        ]);

        if($validator->fails()) {
            $data = [
               'message' => 'Error en la validación de los datos',
               'status' => 400,
               'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        }
        if($request->has('name')){
            $student->name = $request->name;
        }
        if($request->has('email')){
            $student->email = $request->email;
        }
        if($request->has('phone')){
            $student->phone = $request->phone;
        }
        if($request->has('language')){
            $student->language = $request->language;
        }

        $student->save();

        $data = [
           'message' => 'Estudiante actualizado correctamente',
           'status' => 200,
           'student' => $student
        ];
        return response()->json($data, 200);
    }

}
