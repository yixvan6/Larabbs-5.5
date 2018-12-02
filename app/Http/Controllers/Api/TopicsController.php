<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Http\Requests\Api\TopicRequest;
use App\Transformers\TopicTransformer;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();

        return $this->response->item($topic, new TopicTransformer())
            ->setStatusCode(201);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->all());

        return $this->response->item($topic, new TopicTransformer());
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->delete();

        return $this->response->noContent();
    }

    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();

        if ($category_id = $request->category_id) {
            $query->where('category_id', $category_id);
        }

        switch ($request->order) {
            case 'recent':
                $query->latest();
                break;

            default:
                $query->latest('updated_at');
                break;
        }

        $topics = $query->paginate();

        return $this->response->paginator($topics, new TopicTransformer());
    }

    public function userIndex(User $user)
    {
        $topics = $user->topics()->latest()->paginate();

        return $this->response->paginator($topics, new TopicTransformer());
    }
}
