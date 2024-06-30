<?php

namespace App\Events\CS;

//TODO jl can this file delete?

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $userName;
    public $userAvatar;
    public $roomId;
    public $type;
    public $msg;

  /**
   * Create a new event instance.
   *
   * @param $roomId
   * @param $msg
   * @param $type
   */
    public function __construct($roomId, $msg, $type) {
      if($type=='teacher'){
        $user = Auth::user();
        $this->userId = $user->id;
        $this->userName = $user->profile->name;
        if(!is_null($user->profile->avatar)){
          $this->userAvatar = $user->profile->avatar->path.$user->profile->avatar->name;
        }else{
          $this->userAvatar = null;
        }
        $this->roomId = $roomId;
        $this->msg = $msg;
      }else{
        $user = Auth::guard('cs_user')->user();
        $this->userId = $user->id;
        $this->userName = $user->student->name;
        if(!is_null($user->student->profile_pics)){
          $this->userAvatar = $user->student->profile_pics->path.$user->student->profile_pics->name;
        }else{
          $this->userAvatar = null;
        }
        $this->roomId = $roomId;
        $this->msg = $msg;
      }
      $this->type = $type;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat.'.$this->roomId);
    }

    public function broadcastAs(){
      return 'message.update';
    }
}
