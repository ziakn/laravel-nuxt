<?php
namespace App\Repositories\Blog;


use App\Repositories\Blog\BlogInterface as BlogInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Blog;
use DB;
use Auth;
use Session;
use Redirect;
class BlogRepository implements BlogInterface
{
    public function index($request)
    {
        $data=Blog::orderBy('id','DESC')->with('category');
        if(isset($request->category_id) && !empty($request->category_id))
        {
            // dd($request->category_id);
            $data=$data->where('category_id', $request->category_id);
        }    
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
            $create=Blog::create(
                [
                    'user_id' => $auth_id,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $request->image,
                    'status' => 1,
                    'viewed' => 0,
                    'liked' => 0,
                    'meta_title' => $request->meta_title,
                    'meta_tag' => $request->meta_tag,
                    'meta_description' => $request->meta_description,
                ]
            );
            $response['status'] = true;
            $response['data']=Blog::with('category')->find($create->id);
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
        Blog::find($id)->increment('viewed');
        $data = Blog::find($id);
        return $data;
    }

    
    public function edit($request, $id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
                $response['data']=Blog::where('id',$id)
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
            Blog::where('id',$id)
            ->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $request->image,
                    'meta_title' => $request->meta_title,
                    'meta_tag' => $request->meta_tag,
                    'meta_description' => $request->meta_description,
            ]);
            DB::commit();
            $response['status'] = true;
            $response['data']=Blog::with('category')->find($id);
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
         $response['data'] = Blog::find($id);
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