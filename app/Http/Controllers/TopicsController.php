<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, User $user)
	{
		$topics = Topic::orderWith($request->order)->paginate();
        $active_users = $user->getActiveUsers();

		return view('topics.index', compact('topics', 'active_users'));
	}

    public function show(Topic $topic, Request $request)
    {
        if ($topic->slug && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();

		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = \Auth::id();
		$topic->save();

		return redirect()->to($topic->link())->with('success', '话题创建成功！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();

		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '话题更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '话题删除成功！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $response = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => '',
        ];

        if ($file = $request->upload_file) {
            $result = $uploader->save($file, 'topic', \Auth::id(), 1024);
            // 上传成功
            if ($result) {
                $response['success'] = true;
                $response['msg'] = '上传成功';
                $response['file_path'] = $result['path'];
            }
        }

        return $response;
    }
}