<?php

namespace Reg2005\LaravelSelectel;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Rackspace\RackspaceAdapter;
use OpenCloud\OpenStack;
use League\Flysystem\Filesystem as Flysystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Arr;

class SelectelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initSelectelStorage();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function initSelectelStorage(){

        //Extending storage
        return Storage::extend('selectel', function($app, $config){

            $client = new OpenStack($config['endpoint'], [
                'username' => $config['username'], 'password' => $config['key'],
            ]);

            $configFlysystem = Arr::only($config, ['visibility']);

            $configFlysystem = count($configFlysystem) > 0 ? $configFlysystem : null;

            return new FilesystemAdapter(new Flysystem(
                new RackspaceAdapter($this->getSelectelContainer($client, $config)), $configFlysystem
            ));
        });

    }

    /**
     * Get the Selectel Cloud Files container.
     *
     */
    protected function getSelectelContainer(OpenStack $client, array $config)
    {

        $store = $client->objectStoreService('swift', 'common');
        $container = $store->getContainer($config['container']);

        return $container;
    }
}
