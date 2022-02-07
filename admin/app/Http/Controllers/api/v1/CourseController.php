<?php
namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use App\Http\Controllers\Controller;
use App\Http\Validator\CourseValidator;
use App\Models\Course;
use App\Models\CourseDetails;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public $model = null;
    public $validator = null;
    public $repository = null;

    public function __construct(Course $model, CourseValidator $validator)
    {
        // $this->middleware('client');
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
        $data = $request->only($this->model->getModel()->fillable);
        $course_id = Str::random($length = 10);

        $last_order = Course::orderBy('sort_order', 'desc')->first();

        if(!$last_order) {
            $data['sort_order'] = $last_order + 1;
        } else {
            $data['sort_order'] = 1;
        }
        $data['course_id'] = $course_id;
        $data['created_by'] = 1;
        
        $validated = $this->validate($data, $this->validator->rules($data), $this->validator->getMessages());

        if ($validated->fails()) {
            $error = $this->validationErrors($validated->errors());
            $message = [
                'status' => 'error',
                'data' => $error->original
            ];
            return $message;
        }
        $subs_collection = $request->subs_list;
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
                $subscriptions = new CourseDetails;
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
        $res = Course::findorfail($id);
        $data = $request->only($this->model->getModel()->fillable);
        $validated = $this->validate($data, $this->validator->updaterules(), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {

            $subs_collection = $request->subs_list;
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
                    $subscriptions = new CourseDetails;
                    $subscriptions->course_id = $newData->id;;
                    $subscriptions->subscription_id = $value;
                    $subscriptions->created_by = 1;
                    $subscriptions->save();
                };
            });
            $res->update($data);
            return $this->toJson(['status', 'success'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $has_item = $this->repository->checkBiddingHasItems($id);

        // if ($has_item) {
        //     throw new BadRequestHttpException('You cannot delete bidding with PR items.');
        // }

        // $validation = $this->repository->validateUser($request);
        // if ($validation) {
        //     BiddingStatus::query()->where('bid_id', '=', $id)->delete();
        //     Bidding::destroy($id);
        // } else {
        //     throw new BadRequestHttpException('Error: Invalid password entered.');
        // }

        // return $this->toJson(['status'=>'success'], 200);
    }
}
