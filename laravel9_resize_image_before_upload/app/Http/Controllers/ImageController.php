<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Image;
  
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imageUpload');
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
   
        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
       
        $destinationPathThumbnail = public_path('/thumbnail');
        $img = Image::make($image->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);
     
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $imageName);
     
        return back()
            ->with('success','Image Upload successful')
            ->with('imageName',$imageName);
    }
}