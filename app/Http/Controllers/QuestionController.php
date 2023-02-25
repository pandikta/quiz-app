<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function quiz()
    {
        return view('question');
    }

    public function index()
    {
        $data = Question::all();
        return response()->json([
            'message' => 'Get all question success',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
            'answer' => 'required|number',
            'score' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Question::create([
            'question' => $request->question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'sccore' => $request->sccore,
        ]);

        return response()->json([
            'message' => 'Question succesful added',
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Question::find($id);
        if (is_null($data)) {
            $respone  = [
                'message' => 'Id ' . $id . ' not found'
            ];
            return response()->json($respone, 404);
        } else {
            $respone = [
                'message' => 'Qeustion ' . $data->question,
                'data' => $data,
            ];
            return response()->json($respone, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Question::find($id);
        if (is_null($data)) {
            $respone  = [
                'message' => 'Id ' . $id . ' not found'
            ];
            return response()->json($respone, 404);
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
            'answer' => 'required|number',
            'score' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data->update([
            'question' => $request->question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'sccore' => $request->sccore,
        ]);

        $respone = [
            'message' => 'data succesful updated',
            'data' => $data,
        ];
        return response()->json($respone, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Question::find($id);
        if (is_null($data)) {
            $respone  = [
                'message' => 'Id ' . $id . ' not found'
            ];
            return response()->json($respone, 404);
        }
        $data->delete();
        $response = [
            'message' => 'Data success deleted'
        ];
        return response()->json($response, 200);
    }
}
