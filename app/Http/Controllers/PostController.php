<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表页面
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->with('user')->paginate(10);
        return view("post/index", compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
                'title' => 'required|string|min:3',
                'content' => 'required|min:10',
            ]
        );
        if ($valid->fails()) {
            return redirect('/posts/create')->withErrors($valid);
        }
        $post = request(['title', 'content']);
        $user_id = Auth::id();

        $post = Post::create(array_merge($post, compact('user_id')));

        if ($post) {
            return redirect('/posts');
        } else {
            return redirect('/posts/create')->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('comments');
        return view('post/show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $valid = Validator::make(request()->all(), [
                'title' => 'required|string|max:100|min:5',
                'content' => 'required|string|min:10'
            ]
        );

        $this->authorize('update', $post);

        $post->title = \request('title');
        $post->content = \request('content');
        $post->save();
        //
        return redirect("/posts/{$post->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect('posts');
    }

    /**
     * demo
     * 2018/3/10 16:45
     * Administrator
     * imageUpload
     * 上传图片
     */
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));

        return asset('storage/' . $path);
    }

    public function comment(Post $post)
    {
        $this->validate(\request(), [
                'content' => 'required|min:3'
            ]
        );

        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = \request('content');
        $post->comments()->save($comment);

        return back();

    }

    public function zan(Post $post)
    {
        $param = [
            'user_id' => \Auth::id(),
            'post_id' => $post->id
        ];

        Zan::firstOrCreate($param);

        return back();
    }

    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    public function search(Request $request)
    {
        $this->validate($request, [
                'query' => 'required',
            ]
        );

        $query = request('query');
        $posts = \App\Post::search($query)->paginate(5);

        return view("post/search", compact('posts', 'query'));
    }


}
