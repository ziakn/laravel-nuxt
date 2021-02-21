<?php
namespace App\Repositories\User;


use App\Repositories\User\UserInterface as UserInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;
use Auth;
use Session;
use Redirect;
class UserRepository implements UserInterface
{
    public function index($request)
    {
        $data=User::orderBy('id','DESC');    
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
        // dd($request->all());
            $response=array();
            $response['status']=false;
            $response['data'] ='';
            DB::beginTransaction();
            try 
            {
                $data=new User;
                $data->name=$request->input('name');
                $data->email=$request->input('email');
                $data->password=bcrypt($request->input('password'));
                $data->save(); 
                DB::commit();
                $response['data']=User::find($data->id);  
                $response['status'] = true;
            } catch (\Exception $e) {
                $response['data']=$e->getMessage();
                $response['status'] = false;
                DB::rollback();
            }
                
            return response()->json($response);
    }

   
    public function show($id)
    {
        $data=User::find($id);
        return $data;
    }

    
    public function edit($request, $id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
                $response['data']=User::where('id',$id)
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
           User::where('id',$id)
            ->update(
            [
                'name' => $request->name,
            ]
        );
        DB::commit();
        $response['status'] = true;
        $response['data']=User::find($data->id);   
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
         $response['data'] = User::find($id);
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

    public function profile()
    {
        $data=Auth::user();
        return $data;
    }

    public function session()
    {
        $auth_id=Auth::id();
        $data=DB::table('sessions')->where('user_id',$auth_id)->get();
        return $data;
    }

    public function logout()
    {
        $user_id = Auth::id();
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

    public function avatar($request)
     {
         $user_id = Auth::id();
         $request->file('myFile')->store('public/uploads/avatar');
         $pic= '/storage/uploads/avatar/'.$request->myFile->hashName();   
         $update=User::where('id', $user_id)->update([
             'image' => $pic
         ]);
         if($update)
         {
          return response()->json([
              'data' => $pic,
              'status' => true
          ],200);
          }
          return response()->json([
              'data' => 'Failed',
              'status' => false
          ],200);
     }

     public function changePass($request)
     {
         
         $request->validate([
             'newPassword' => ['required'],
             'confirmPassword' => ['same:newPassword'],
         ]);
         if(!Hash::check($request->oldPassword,Auth::user()->password))
         {
             return response()->json(
                 [
                     'status'=> false,
                     'message'=> 'Current Password dose not matched'
                 ], 200);
         }
         else
         {                     
             $update=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);  
             if($update)   
             {
                 return response()->json(
                     [
                         'status'=> true,
                         'message'=> 'Successfuly Changed'
                     ], 200);
             } 
             else
             {
                 return response()->json(
                     [
                         'status'=> false,
                         'message'=> 'Failed, Try again'
                     ], 200);
             }
 
         }
     }
}