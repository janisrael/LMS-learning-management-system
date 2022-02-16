<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\LessonRepository;
use App\Http\Validator\LessonValidator;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{

    public $model = null;
    public $validator = null;
    public $repository = null;

    public function __construct(Lesson $model, LessonValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->repository = new LessonRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->searchList($this->repository, $request);
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

        $last_order = Lesson::orderBy('sort_order', 'desc')->first();

        if(!$last_order) {
            $data['sort_order'] = $last_order + 1;
        } else {
            $data['sort_order'] = 1;
        }

        $data['created_by'] = Auth::user()->id;
        $data['author_id'] = 1;
        
        $validated = $this->validate($data, $this->validator->rules($data), $this->validator->getMessages());

        if ($validated->fails()) {
            $error = $this->validationErrors($validated->errors());
            $message = [
                'status' => 'error',
                'data' => $error->original
            ];
            return $message;
        }

        $subs_collection_resources = $request->resources;
        $subs_collection_faqs = $request->faqs;
        
        // if (!$subs_collection_resources) {
        //     $err = [];
        //     array_push($err, 'Resources is required');
        //     $message = [
        //         'status' => 'error',
        //         'data' => [
        //             'errors' => [
        //                 'name' => $err
        //             ],
        //             'messages' => 'Validator Errors'
        //         ]
        //     ];
        //     return $message;
        // }

        // if (!$subs_collection_faqs) {
        //     $err = [];
        //     array_push($err, 'Faq is required');
        //     $message = [
        //         'status' => 'error',
        //         'data' => [
        //             'errors' => [
        //                 'name' => $err
        //             ],
        //             'messages' => 'Validator Errors'
        //         ]
        //     ];
        //     return $message;
        // }
      
        DB::transaction(function () use ($data, $subs_collection_resources, $subs_collection_faqs) {
            $newData = $this->model->create($data);
            foreach($subs_collection_resources as $item){
                // dd(array($item));
                $resource = new Resource;
                $resource->lesson_id = $newData->id;;
                $resource->name = $item['name'];
                $resource->file = $item['path'];
                $resource->created_by = 1;
                $resource->status = 1;
                $resource->save();
            };

            foreach($subs_collection_faqs as $faq_item => $faq_value){
                $faq = new Faq;
                $faq->lesson_id = $newData->id;
                $faq->question = $faq_value['question'];
                $faq->answer = $faq_value['answer'];
                $faq->created_by = 1;
                $faq->status = 1;
                $faq->save();
            };
        });

        $message = [
            'status' => 'success',
            'data' => $data
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
