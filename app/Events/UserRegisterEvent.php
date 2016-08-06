<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Transformers\UserTransformer;
use App\User;

class UserRegisterEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Los Atributos deben de ser public cuando no hay un broadcastWith().
     *
     * @var Usuario
     */
    protected $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {

        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['laravue-channel'];
    }

    /**
     * Get the broadcast event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'laravue.user.register';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */

    public function broadcastWith()
    {

        $user = fractal()->item($this->user)
                    ->transformWith(new UserTransformer)
                    ->toJson();

        return [
            'user' => json_decode($user)
        ];
    }

}