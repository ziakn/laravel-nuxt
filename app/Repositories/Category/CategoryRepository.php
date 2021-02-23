<?php
namespace App\Repositories\Category;


use App\Repositories\Category\CategoryInterface as CategoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use DB;
use Auth;
use Session;
use Redirect;
class CategoryRepository implements CategoryInterface
{
    public function index($request)
    {
        $data=Category::orderBy('id','DESC');    
        if(isset($request->show) && !empty($request->show))
        {
            $show=$request->show;
            $data=$data->paginate($show);
        }
        else
        {
            $data=$data->paginate(20);
        }
        return $data;
    }

     
    public function create()
    {

    }

   
    public function store($request)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        $auth_id=Auth::id();
        DB::beginTransaction();
        try {  
            $response['data']=Category::create(
                [
                    'user_id' => $auth_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => 1,
                    'meta_title' => $request->meta_title,
                    'meta_tag' => $request->meta_tag,
                    'meta_description' => $request->meta_description,
                ]
            );
            $response['status'] = true;
            DB::commit();
        } catch (\Exception $e) {
            $response['data']=$e->getMessage(). ', Line: '.$e->getLine();
            $response['status'] = false;
            DB::rollback();
        }
            
        return response()->json($response);
    }

   
    public function show($id)
    {
        
    }

    
    public function edit($request, $id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
                $response['data']=Category::where('id',$id)
                ->update([
                    'status' => $request->status=='true'?1:0,
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

    
    public function update($request,  $id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
            Category::where('id',$id)
            ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'meta_title' => $request->meta_title,
                    'meta_tag' => $request->meta_tag,
                    'meta_description' => $request->meta_description,
            ]);
            DB::commit();
            $response['status'] = true;
            $response['data']=Category::find($id);
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
         $response['data'] = Category::find($id);
         if($response['data'])
         {
            $response['data']=$response['data']->delete();
            $response['status']=true;     
         }
         else
         {
            $response['data']="Data Not deleted";  
         }
         return response()->json($response);
    }

}