<?php
namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use App\Http\Controllers\Controller;
use App\Http\Validator\CourseValidator;
use App\Models\Course;
use App\Models\CourseHasSubscriptions;
use Illuminate\Support\Str;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CourseController extends Controller
{
    public $model = null;
    public $validator = null;
    public $repository = null;

    public function __construct(Course $model, CourseValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->repository = new CourseRepository($model);
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
        // dd($request);
        $data = $request->only($this->model->getModel()->fillable);
        $course_id = Str::random($length = 10);

        $last_order = Course::orderBy('sort_order', 'desc')->first();

        if(!$last_order) {
            $data['sort_order'] = $last_order + 1;
        } else {
            $data['sort_order'] = 1;
        }
        $data['course_number'] = $course_id;
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

        $subs_collection = [1,2];

        // dd($subs_collection);
        if (!$subs_collection) {
            $err = [];
            array_push($err, 'No Subscription selected');
            $message = [
                'status' => 'error',
                'data' => [
                    'errors' => [
                        'name' => $err
                    ],
                    'messages' => 'Validator Errors'
                ]
            ];
            return $message;
        }
        DB::transaction(function () use ($data, $subs_collection) {
            $newData = $this->model->create($data);
            foreach($subs_collection as $item => $value){
                $subscriptions = new CourseHasSubscriptions;
                $subscriptions->course_id = $newData->id;;
                $subscriptions->subscription_id = $value;
                $subscriptions->created_by = 1;
                $subscriptions->save();
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
        // $cat = $this->model->findorFail($id);
        // return $this->toJson(['Category',$cat],200);
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
        $data = $request->only($this->model->getModel()->fillable);
        $validated = $this->validate($data, $this->validator->storerules($data['id']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }

        $result = $this->repository->handleUpdate($request, $data, $id);
        return response()->json($result->original);
        // $newdata = Course::findorfail($id);
        // $subs_collection = $request->subs_list;
        // if (!$subs_collection) {
        //     return $this->toJson(['status' => 'error', 'message' => 'Please Select atleast 1 Subscriptions'], 400);
        // }
        // else {

        //     DB::transaction(function () use ($id, $subs_collection, $request) {
        //         $check_subs = CourseHasSubscriptions::where('course_id', '=', $request->id)->get();

        //         foreach($check_subs as $check => $check_value) {
        //             $item_to_delete = CourseHasSubscriptions::find($check_value->id);
        //             $item_to_delete->delete();
        //         };

        //         foreach($subs_collection as $item => $value){
        //             $subscriptions = new CourseHasSubscriptions;
        //             $subscriptions->course_id = $id;
        //             $subscriptions->subscription_id = $value;
        //             $subscriptions->created_by = 1;
        //             $subscriptions->save();
        //         };
        
        //     });

        //     $newdata->update($data);
        // dd($result);
        
            // return $this->toJson(['response' => $result]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lessons = Lesson::query()->where('course_id', '=', $id)->exists();
        if ($lessons) {
            return $this->toJson(['error'=>'You cannot delete Course with active lessons.'], 400);
        }

        // $validation = $this->repository->validateUser($request);
        // if ($validation) {
            Course::destroy($id);
        // }

        return $this->toJson(['status'=>'success'], 200);
    }
}
