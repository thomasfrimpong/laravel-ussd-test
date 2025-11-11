<?php

namespace Illuminate\Contracts\Container;

if (!interface_exists(__NAMESPACE__ . '\\Container')) {
    interface Container
    {
        public function make($abstract, array $parameters = []);
    }
}

namespace Illuminate\Contracts\Events;

if (!interface_exists(__NAMESPACE__ . '\\Dispatcher')) {
    interface Dispatcher
    {
        public function dispatch(object $event);
    }
}

namespace Illuminate\Contracts\Config;

if (!interface_exists(__NAMESPACE__ . '\\Repository')) {
    interface Repository
    {
        public function get($key, $default = null);
    }
}
