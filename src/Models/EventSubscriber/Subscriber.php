<?php
/**
 * Created by PhpStorm.
 * User: menq
 * Date: 6/27/17
 * Time: 3:05 PM
 */

namespace Btybug\Manage\Models\EventSubscriber;


class Subscriber
{
    private $path;
    private $events;
    private $properties;
    private $data;
    private $store = [];

    public function __construct($old_obj = null)
    {
        $this->path = storage_path('app' . DS . 'event_subscriber.json');
        if ($old_obj) {
            $this->store = $old_obj->store;
            $this->events = $old_obj->events;
            $this->properties = $old_obj->properties;
        }

        $this->data = $this->dataReader();
    }

    private function dataReader()
    {
        if (\File::exists($this->path)) {
            return array_merge(json_decode(\File::get($this->path), true), $this->store);
        }
        return $this->store;
    }

    public function addAction($event, $action, $settings = [])
    {
        return $this->store[$event][$action . '$' . uniqid()] = $settings;
    }

    public function addEvent($name, $namespace)
    {
        $this->events[$name] = $namespace;
        return $this;
    }

    public function addProperty($name, $namespace)
    {
        $this->properties[$name] = $namespace;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function save()
    {
        \File::put($this->path, json_encode($this->data));
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getEvents($lists = false)
    {
        if (!$lists) {
            return $this->events;
        }
        $listData = [];
        foreach ($this->events as $key => $value) {
            $listData[$value] = $key;
        }
        return $listData;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getAll()
    {
        return new Subscriber($this);
    }

    public function cleaner($event, $function)
    {
        if (isset($this->data[$event])) {
            foreach ($this->data[$event] as $key => $value) {
                if (strpos($key, $function) === 0) {

                    unset($this->data[$event][$key]);
                }
            }
        }
        return $this;
    }

}