<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $posts = Post::with('user')->latest()->paginate(4);
        $key = $request->key;
        $keys = $request->keys;
        $query = Post::query();

        if (!empty($key)) {
            $query
                ->where('title', 'like', '%' . $key . '%');
        }

        if (!empty($keys)) {
            $query->whereHas('Category', function ($q) use ($keys) {
                $q->where('point', 'like', '%' . $keys . '%')
                    ->orwhere('id', 'like', '%' . $keys . '%');
            });
        }

        // orderByメソッドでは第1引数に基準にしたいカラム、第2引数に降順か昇順家指定する
        $posts = $query->orderBy('created_at', 'desc')->paginate(4);
        return view('posts.index', compact('posts', 'key', 'keys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post($request->all());
        $post->user_id = $request->user()->id;
        $post->category_id = $request->category_id;

        $file = $request->file('image');
        $post->image = self::createFileName($file);
        try {
            $post->save();

            if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'IPPON COMPLETED!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);



        if ($request->user()->cannot('update', $post)) {
            return redirect()->route('posts.show', $post)
                ->withErrors('許可されていない操作です');
        }

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $post->image_path;
            $post->image = self::createFileName($file);
        }
        $post->fill($request->all());
        $post->category_id = $request->category_id;
        try {
            $post->save();

            if ($file) {
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                if (!Storage::delete($delete_file_path)) {
                    Storage::delete($post->image_path);
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }

        return redirect()->route('posts.show', $post)
            ->with('notice', 'UPDATED IPPON!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        try {
            $post->delete();

            if (!Storage::delete($post->image_path)) {
                throw new \Exception('failed to delete a photo');
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('posts.index')
            ->with('notice', 'DELETED IPPON!');
    }

    private static function createFileName($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
