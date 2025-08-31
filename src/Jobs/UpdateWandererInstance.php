<?php

namespace RecursiveTree\Seat\WandererAccessSync\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListInstance;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListRole;
use Seat\Eveapi\Models\RefreshToken;

class UpdateWandererInstance implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Dispatchable;

    private WandererAccessListInstance $accessListInstance;

    /**
     * @param WandererAccessListInstance $accessListInstance
     */
    public function __construct(WandererAccessListInstance $accessListInstance)
    {
        $this->accessListInstance = $accessListInstance;
    }

    public function handle()
    {
        // since the access list id is a UUID, we can assume it is unique even across wanderer installs
        $access_list_roles = WandererAccessListRole::with(['role'])
            ->where('wanderer_instance_id', $this->accessListInstance->id)
            ->get();
        if($access_list_roles->isEmpty()) return;

        $user_ids = collect();
        foreach ($access_list_roles as $role) {
            $user_ids = $user_ids->merge($role->role->users()->pluck('id'));
        }

        $access_list = $this->accessListInstance->getAccessList();
        $access_list->seedMembers();

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