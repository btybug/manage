<?php

namespace Btybug\Manage\Models\EventSubscriber\Independent;

/**
 * Created by PhpStorm.
 * User: menq
 * Date: 6/28/17
 * Time: 8:35 PM
 */
abstract class Independent
{
    protected $forms = [];

    public function __call($name, $arguments)
    {
        $methodArray = explode('$', $name);
        $method = $methodArray[0];
        if (method_exists($this, $method)
            && is_callable(array($this, $method))
        ) {
            $namespace = static::class . '@' . $name;
            $subscribe = \Subscriber::getSubscriptions();
            $event = $arguments[0];
            $data = $subscribe->getData();
            $arguments[] = $this->recursive_array_search($namespace, $data[$event->namespace]);
            return call_user_func_array([$this, $method], $arguments);
        } else {
            throw new Exception('Method not defined');
        }
    }

    private function recursive_array_search($needle, $haystack)
    {
        foreach ($haystack as $key => $value) {
            if ($key == $needle) {
                return $value;
            }
        }
        return false;
    }

}