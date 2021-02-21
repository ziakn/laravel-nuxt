<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageFolder\ImageFolderInterface as ImageFolderInterface;

class ImageFolderController extends Controller
{
    
    public function __construct(ImageFolderInterface $imagefolder)
    {
        $this->imagefolder = $imagefolder;
    }

    public function index(Request $request)
    {
        $data= $this->imagefolder->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->imagefolder->store($request);
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
        $data=$this->imagefolder->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->imagefolder->destroy($id);
        return $data;
    }
}
