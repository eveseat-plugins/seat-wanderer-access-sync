<?php

namespace RecursiveTree\Seat\WandererAccessSync\Models;

use RecursiveTree\Seat\WandererAccessSync\Driver\WandererAccessList;
use Seat\Services\Models\ExtensibleModel;
use Seat\Web\Models\Acl\Role;

/**
 * @property string $wanderer_url
 * @property string $access_list_id
 * @property string $access_list_token
 */
class WandererAccessListInstance extends ExtensibleModel
{
    public $timestamps = false;
    protected $table = 'seat_wanderer_access_sync_instances';

    public function getAccessList(): WandererAccessList
    {
        return new WandererAccessList($this->access_list_id, $this->access_list_token, $this->wanderer_url);
    }
}