<?php

namespace RecursiveTree\Seat\WandererAccessSync\Models;

use RecursiveTree\Seat\WandererAccessSync\Driver\WandererAccessList;
use Seat\Services\Models\ExtensibleModel;
use Seat\Web\Models\Acl\Role;

/**
 * @property WandererAccessListInstance $accessList
 * @property Role $role
 */
class WandererAccessListRole extends ExtensibleModel
{
    public $timestamps = false;
    protected $table = 'seat_wanderer_access_sync_roles';

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function accessList()
    {
        return $this->belongsTo(WandererAccessListInstance::class,'wanderer_instance_id','id');
    }
}