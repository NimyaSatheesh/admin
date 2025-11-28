<?php

namespace App\Http\Controllers\Admin\Faqs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Yajra\DataTables\Facades\DataTables;



class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $faqs = Faq::select('id', 'question', 'answer')->latest();

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->make(true);
        }
    
        return view('admin.faqs.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "question" => "required",
            "answer"   => "required",
        ]);
    
        Faq::create($request->only('question', 'answer'));
    
        return response()->json([
            'status' => 200,
            'message' => 'FAQ created'
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "question" => "required",
            "answer"   => "required",
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->only('question','answer'));

        return response()->json(['status'=>200,'message'=>'FAQ Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();

        return response()->json(['status'=>200,'message'=>'FAQ Deleted']);
    }
}
