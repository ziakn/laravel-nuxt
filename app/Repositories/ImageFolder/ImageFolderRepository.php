<?php
namespace App\Repositories\ImageFolder;


use App\Repositories\ImageFolder\ImageFolderInterface as ImageFolderInterface;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use App\Models\ImageFolder;

class ImageFolderRepository implements ImageFolderInterface
{
    
    
    
    public function index($request)
    {
        $auth_id=Auth::id(); 
        $find=ImageFolder::orderBy('id','ASC')->first();
        if($find == null)
        {
            ImageFolder::create(
                [
                    'user_id' => $auth_id,
                    'parent_id' => 1,
                    'name' => 'name',
                    'description' => 'description',
                    'status' => 1,
                ]
            );
        }
        $data=ImageFolder::noRoot()->orderBy('id','ASC')
        ->where('user_id',$auth_id);    
        if(isset($request->parent_id) && !empty($request->parent_id))
        {
            $data= $data->where('parent_id',$request->parent_id);
        }
        $data= $data->get();
        return $data;
    }
    public function create()
    {
        //
    }


    public function store($request)
    {
        $auth_id=Auth::id();
        $request->merge(['user_id' => $auth_id]);
        // $data->user_id=$auth_id;
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        $validator = Validator::make(
            $request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response['data'] =$validator->errors();
            return response()->json($response,200);
        }
        DB::beginTransaction();
        try {
            $response['data']=ImageFolder::create($request->all());           
            DB::commit();
            $response['status'] = true;
        } catch (\Exception $e) {
            $response['data']=$e->getMessage();
            DB::rollback();
        }

        return response()->json($response);
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
    
    public function update($request, $id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        $validator = Validator::make(
            $request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response['data'] =$validator->errors();
            return response()->json($response,200);
        }

        DB::beginTransaction();
        try {
            $response['data']=ImageFolder::where('id',$id)
            ->update([
                'user_id' => $request->user_id,
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);
            DB::commit();
            $response['status'] = true;
        } catch (\Exception $e) {
            $response['data']=$e->getMessage();
            $response['status'] = false;
            DB::rollback();
        }
            
        return response()->json($response);
    }
    public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] = ImageFolder::find($id);
        if($response['data'])
        {
                $response['data']=$response['data']->delete();
                $response['status']=true;
        }
        else
        {
            $response['data']="Status not Exist";  
        }
        return response()->json($response);

    }
    
}
