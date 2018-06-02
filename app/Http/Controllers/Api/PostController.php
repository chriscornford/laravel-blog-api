<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:posts'
        ]);

        if ($validator->fails()){
            return response()->json(['data' => $validator->errors()], 422);
        }

        $data['author_id'] = Auth::guard()->user()->id;
        $post = Post::create($data);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! ($post = Post::find($id))) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if ($post->author->id !== Auth::guard()->user()->id) {
            throw new UnauthorizedException();
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'string|max:255',
            'content' => 'string',
            'slug' => 'string|max:255|unique:posts'
        ]);

        if ($validator->fails()){
            return response()->json(['data' => $validator->errors()], 422);
        }

        $post->fill($data);
        $post->save();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! ($post = Post::find($id))) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if ($post->author->id !== Auth::guard()->user()->id) {
            throw new UnauthorizedException();
        }

        $post->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
