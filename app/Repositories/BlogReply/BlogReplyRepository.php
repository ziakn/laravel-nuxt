<?php
namespace App\Repositories\BlogReply;


use App\Repositories\Blog\BlogInterface as BlogInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\BlogReply;
use DB;
use Auth;
use Session;
use Redirect;
class BlogReplyRepository implements BlogReplyInterface
{
    public function index($request)
    {
        $data=BlogReply::orderBy('id','DESC')->with('blog');    
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
            $response['data']=BlogReply::create(
                [
                    'blog_id' => $request->blog_id,
                    'name' => $request->name,
                    'comment' => $request->comment,
                    'email' => $request->email,
                    'status' => 1,
                    'website' => $request->website,
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
                $response['data']=BlogReply::where('id',$id)
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
            BlogReply::where('id',$id)
            ->update([
                    'name' => $request->name,
                    'comment' => $request->comment,
                    'email' => $request->email,
                    'website' => $request->website,
            ]);
            DB::commit();
            $response['status'] = true;
            $response['data']=BlogReply::with('blog')->find($id);
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
         $response['data'] = BlogReply::find($id);
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