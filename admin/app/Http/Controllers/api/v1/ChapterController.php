<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Repositories\ChapterRepository;
use App\Http\Validator\ChapterValidator;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{

    public $model = null;
    public $validator = null;
    public $repository = null;

    public function __construct(Chapter $model, ChapterValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->repository = new ChapterRepository($model);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->middleware('client');
        return $this->searchList($this->repository, $request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getlesson(Request $request) {
        
        $result = $this->repository->getLessonByChapter($request);
        
        return $result;
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

        $data = $request->only($this->model->getModel()->fillable);
        $data['added_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['sort_order'] = 2;
        // $data['ticket_no'] = date('Yds').mt_rand(10, 99);
        $validated = $this->validate($data, $this->validator->rules($data), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        } 

        $res = $this->model->create($data);
        $message = [
            'status' => 'success',
            'data' => $res
        ];

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
