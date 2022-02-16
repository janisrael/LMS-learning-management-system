<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\UnauthorizedException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PER_PAGE = 50;

    public function toJson(array $data, int $statusCode)
    {
        return response()->json($data, $statusCode);
    }

    /**
     * @param $data
     * @param array $rules
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, array $rules, array $messages)
    {
        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationErrors($errors)
    {
        return response()->json([
            'messages' => 'Validation errors',
            'errors' => $errors
        ], 400);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundError($message)
    {
        return response()->json([
            'message' => $message
        ], 404);
    }


    /**
     * @param $message
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccess(String $message = '')
    {
        return $this->toJson(['status' =>'success','message' => $message],200);
    }

    /**
     * @param $message if no value passed, default is declared
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondError(String $message = 'Permission Denied!')
    {
        return $this->toJson(['status' =>'error','message' => $message],201);
    }

    public function checkRolePermission($name, $id = '')
    {
        $authUser = Auth::user();
    

        $user = \App\Models\User::find($authUser->id);

        $flag = false;

        $permission_name = $name;
        if(!empty($id) and is_string($id)){
            $permission_name = $name.'.'.$id;
        }
        
        if($user->hasAuthorityTo($permission_name)){    // if allowed in his/her permission
            $flag = true;
        }

        return $flag;
    }

    public function storedata(Model $model,Request $request,$validator,$action)
    {
        $data = $request->only($model->getModel()->fillable);
        $validated = $this->validate($data, $validator::rules(),$validator::getMessages());
        if ($validated->fails())
        {
            return $this->validationErrors($validated->errors());
        }
        if($action == "create"){
            $model->create($data);
        }else if($action == "update"){
            $model->update($data);
        }
        return $this->toJson(['status'=>'success'],200);
    }


	public function storeDataWithID(Model $model,Request $request,$validator,$action)
	{
		$data = $request->only($model->getModel()->fillable);
		$validated = $this->validate($data, $validator::rules($data['personnel_id']),$validator::getMessages());
		if ($action == "update") {
			$validated = $this->validate($data, $validator::update_rules($data['id'],$data['personnel_id']),$validator::getMessages());
		}
		if ($validated->fails())
		{
			return $this->validationErrors($validated->errors());
		}
		if($action == "create"){
			$model->create($data);
		}else if($action == "update"){
			$model->update($data);
		}
		return $this->toJson(['status'=>'success'],200);
    }
    
    /**
     * @param Model $model
     * @param null $term
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewList(Model $model,$term=null,$page = 1){
        $count = $model::all()->count();
        $data = $model::paginate(self::PER_PAGE, ['*'], 'page', $page);

        return response()->json([
            $model::NAME => $data->items(),
            'meta'=>$this->getMeta($data, $count)
        ],200);
    }

        /**
     * @param Model $model
     * @param null $otherTable
     * @param null $term
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewListWithOtherTable(Model $model,$otherTable = null,$term=null,$page = 1){
        if($otherTable === null){
            $count = $model::all()->count();
            $data = $model::paginate(self::PER_PAGE, ['*'], 'page', $page);
        }else{
            $count = $model->with($otherTable)->count();
            $data = $model->with($otherTable)->paginate(self::PER_PAGE, ['*'], 'page', $page);
        }

        return response()->json([
            $model::NAME => $data->items(),
            'meta'=>$this->getMeta($data, $count)
        ],200);
    }

        /**
     * Search in repository by passing request for filters
     * @param Repository $repository
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchList(Repository $repository, Request $request)
    {
  
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? self::PER_PAGE;
        $collection = $repository->search($request);
        $count = $collection->get()->count();

        return response()->json([
            $repository->getModel()::NAME => $collection->paginate($perPage,['*'],'1',$page)->items(),
            'meta'=>$this->getMetaData($count, $page, $perPage)
        ]);
    }

        /**
     * Search in repository by passing request for filters and Return a Collection
     * @param Repository $repository
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchListCollection(Repository $repository, Request $request){
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? self::PER_PAGE;
        $collection = $repository->getData($request);
        $count = count($collection);

        return response()->json([
            $repository->getModel()::NAME  => collect($collection)->forPage($page,$perPage),
            'meta' => $this->getMetaData($count, $page, $perPage)
        ]);
    }

      /**
     * Search in repository by passing request for filters with order by
     * @param Repository $repository
     * @param Request $request
     * @param string $orderBy
     * @param string $clause
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchListOrderBy(Repository $repository, Request $request, string $orderBy, string $clause)
    {
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? self::PER_PAGE;
        $collection = $repository->search($request)->orderBy($orderBy,$clause);
        $count = $collection->get()->count();

        return response()->json([
            $repository->getModel()::NAME => $collection->paginate($perPage,['*'],'1',$page)->items(),
            'meta'=>$this->getMetaData($count, $page, $perPage)
        ]);
    }
     /**
     * Deprecated
     * @param $paginator
     * @param $count
     * @return array
     */
    public function getMeta($paginator, $count)
    {
        return [
                'total' => $count,
                'page' => $paginator->currentPage(),
                'first_page' => $paginator->firstItem(),
                'last_page' => $paginator->lastItem(),
                'per_page' => $paginator->perPage()
        ];
    }

    public function getMetaData(int $count, int $page, int $perPage)
    {
        return [
            'total' => $count,
            'page' => $page,
            'per_page' => $perPage
        ];
    }

    public function moveFile($request) {
        $request_from = $request->path();
        $putFilesTo = '';
        $oldFilePath = 'public\temp_files' . '\\';
        if(strpos($request_from, 'lessons') !== false){
            if(strpos($request_from, 'resources') !== false){
                $putFilesTo = 'public\lessons\resources';
            }
            else {
                $putFilesTo = 'public\lessons';
            }
        }

        if(strpos($request_from, 'courses') !== false){
            $putFilesTo = 'public\courses' . '\\';
        }

        $file_name = $request->course_image_url;
        $old_file =  $oldFilePath . $file_name;
        $new_file = $putFilesTo . $file_name;

        $response = Storage::move($old_file, $new_file);
        if($response === false) {
            return false;
        }

        return true;
    }
}
