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
                'email' => 'required',
                'phone' => 'required',
                'language' => 'required',
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
}
