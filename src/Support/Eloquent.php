<?php

namespace Splash\Support;

use Illuminate\Database\Capsule\Manager as Capsule;
use function Vansbeck07\Dotenv\loadEnv;
use Splash\Foundation\Path;

/**
 * Eloquent Database Connection.
 */
class Eloquent
{
    public static function connect($default = 'mysql')
    {
        loadEnv(Path::toProject('.env'));

        $capsule = new Capsule();

        $config = require Path::toConfig('database.php');
        $connections = $config['connections'];

        if ($defaultConnection = $connections[$default] ?? $connections[$config['default']] ?? []) {
            $capsule->addConnection($defaultConnection);
        }

        foreach ($connections as $name => $params) {
            $capsule->addConnection($params, $name);
        }

        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}
