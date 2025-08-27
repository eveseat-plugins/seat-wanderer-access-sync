<?php

namespace RecursiveTree\Seat\WandererAccessSync\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use RecursiveTree\Seat\WandererAccessSync\Driver\WandererAccessList;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListRole;
use Seat\Eveapi\Models\RefreshToken;
use Seat\Web\Models\User;

class WandererFullSync implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Dispatchable;

    private WandererAccessListRole $access_list_role;

    /**
     * @param WandererAccessListRole $access_list_role
     */
    public function __construct(WandererAccessListRole $access_list_role)
    {
        $this->access_list_role = $access_list_role;
    }

    public function handle()
    {
        $access_list = $this->access_list_role->getAccessList();
        $access_list->seedMembers();

        $user_ids = $this->access_list_role->role->users()->pluck('id');
        $allowed_character_ids = RefreshToken::whereIn('user_id',$user_ids)->pluck('character_id');

        $forbidden_character_ids = $access_list->getMembers()->diff($allowed_character_ids);

        foreach ($forbidden_character_ids as $character_id){
            $access_list->deleteMember($character_id);
        }

        foreach ($allowed_character_ids as $character_id) {
            $access_list->addMember($character_id);
        }
    }
}