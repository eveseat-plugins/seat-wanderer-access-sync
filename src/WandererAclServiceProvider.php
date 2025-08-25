<?php

namespace RecursiveTree\Seat\RattingMonitor;

use Seat\Services\AbstractSeatPlugin;

use  Seat\Eveapi\Jobs\Status\Status;

class WandererAclServiceProvider extends AbstractSeatPlugin
{
    public function boot(){

    }

    public function register(){

    }

    public function getName(): string
    {
        return 'SeAT Wanderer ACL Manager';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/eveseat-plugins/seat-wanderer-acl';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-wanderer-acl';
    }

    public function getPackagistVendorName(): string
    {
        return 'recursivetree';
    }
}