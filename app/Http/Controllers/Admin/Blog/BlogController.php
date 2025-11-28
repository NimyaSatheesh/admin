<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::latest();

            return DataTables::of($blogs)
                ->addColumn('image', function($row){
                    return '<img src="'.asset('uploads/blogs/'.$row->image).'" width="60" />';
                })
                ->rawColumns(['image'])
                ->make(true);
        }
        return view('admin.blog.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {

        $filename = null;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/blogs/', $filename);
        }

        Blog::create([
            "title"       => $request->title,
            "description" => $request->description,
            "image"       => $filename,
        ]);

        return response()->json(['status'=>200,'message'=>'Blog Created']);
    }

     /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBlogRequest $request, $id)
    {
       
        $blog = Blog::findOrFail($id);

        $blog->title = $request->title;
        $blog->description = $request->description;

        // handle image upload (if provided)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // ensure uploads/blogs exists
            $destination = public_path('uploads/blogs');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // move new file
            $file->move($destination, $filename);

            // delete old file if exists
            if ($blog->image && file_exists($destination . '/' . $blog->image)) {
                @unlink($destination . '/' . $blog->image);
            }

            $blog->image = $filename;
        }

        $blog->save();

        return response()->json(['status' => 200, 'message' => 'Blog Updated Successfully', 'blog' => $blog]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && file_exists('uploads/blogs/'.$blog->image)) {
            unlink('uploads/blogs/'.$blog->image);
        }

        $blog->delete();

        return response()->json(['status'=>200,'message'=>'Blog Deleted']);
    }
}
