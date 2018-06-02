<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class PostController extends BaseController
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
            return $this->createErrorResponse($validator->errors());
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
            return $this->createNotFoundResponse();
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
            return $this->createErrorResponse($validator->errors());
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
            return $this->createNotFoundResponse();
        }

        if ($post->author->id !== Auth::guard()->user()->id) {
            return $this->createUnauthorizedResponse();
        }

        $post->delete();

        return $this->createNoContentResponse();
    }
}
