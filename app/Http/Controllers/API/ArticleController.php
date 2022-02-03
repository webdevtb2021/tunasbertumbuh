<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;

class ArticleController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['user:id,name','articleImages'])->get();
        return response()->json($articles);
    }

    public function indexArticles()
    {
        $articles = Article::with(['user:id,name','articleImages'])->latest()->paginate(10);
        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $article = Article::create([
            'title' =>  $request->title,
            'body' => $request->body,
            'user_id' =>  $request->user_id,
        ]);
        $images = $request->images;
        $i = 0;
        foreach ($images as $image) {
            $i++;
            $filename = $article->id.'_'.$i.'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/articles/'.$filename,$img);
            $article->articleImages()->create(['url_image'=>$filename]);
        }

        return response()->json($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::with(['user:id,name','articleImages'])->findOrFail($id);
        return response()->json($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $article->update([
            'title' =>  $request->title,
            'body' => $request->body,
        ]);
        $article->save();
        $articleIds = $article->articleImages->pluck('id')->toArray();
        $imagesExist = $request->imagesExist;
        if(count($articleIds) != 0){
            if(!$imagesExist)
                $imagesDiff = $articleIds;
            else 
                $imagesDiff = array_diff($articleIds,$imagesExist);
            try {
                $article->articleImages()->whereIn('id', $imagesDiff)->delete();
            }
            catch (\Exception $e) {
            }   
        }   

        $images = $request->images;
        $i = 0;

        if($images != null){
            foreach ($images as $image) {
                $i++;            
                $filename = $article->id.'_'.$i.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->stream();
                Storage::disk('public')->put('/images/articles/'.$filename,$img);
                $article->articleImages()->create(['url_image'=>$filename]);
            }
        }

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return $article;
    }
}
