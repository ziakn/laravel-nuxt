<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\Image\ImageInterface as ImageInterface;

class ImageController extends Controller
{
    
    public function __construct(ImageInterface $image)
    {
        $this->image = $image;
    }

    public function index(Request $request)
    {
        $data= $this->image->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->image->store($request);
        return $data;
    }

   
    public function show($id)
    {
       
    }

    
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        $data=$this->image->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->image->destroy($id);
        return $data;
    }
}
