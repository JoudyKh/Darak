<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\CreateMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::paginate(config('app.pagination_limit'));
        return success($messages);
    }
    public function show(Message $message)
    {
        return success($message);
    }
    public function create(CreateMessageRequest $request)
    {
        $data = $request->validated();
        $message = Message::create($data);
        return success($message);
    }
    // public function update(Request $request, Message $messages)
    // {
    //     $data = $request->all();
    //     $messages->update($data);
    //     return success($messages);
    // }
    public function destroy(Message $message)
    {
        $message->delete();
        return success();
    }
}
