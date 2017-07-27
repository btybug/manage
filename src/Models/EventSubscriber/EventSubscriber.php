<?php

namespace Sahakavatar\Manage\Models\EventSubscriber;


final class EventSubscriber
{
    private static $staticSubscriber;
    private $subscribe;

    public function __construct()
    {
        $this->subscribe = $this->getSubscriber();
    }

    protected function getSubscriber()
    {
        if ($this->subscribe) return $this->subscribe;
        return new Subscriber();
    }

    public static function __callStatic($name, $arguments)
    {
        $method = 'scope' . ucfirst($name);
        if (!self::$staticSubscriber) {
            self::$staticSubscriber = $_this = new self();
        } else {
            $_this = self::$staticSubscriber;
        }

        if (method_exists($_this, $method)
            && is_callable(array($_this, $method))
        ) {
            return call_user_func_array([$_this, 'scope' . ucfirst($name)], $arguments);
        }
    }

    private function scopeSave()
    {
        $this->scopeGetSubscriptions()->save();
        return $this;
    }

    protected function scopeGetSubscriptions()
    {
        return $this->subscribe->getAll();
    }
    protected function scopeGetEvents($lists=false)
    {
        return $this->subscribe->getAll()->getEvents($lists);
    }

    public function delete()
    {

    }

    public function get()
    {

    }

    public function scopeGetStore()
    {
        return $this->subscribe->getStore();
    }

    public function __call($name, $arguments)
    {
        $method = 'scope' . ucfirst($name);
        if (method_exists($this, $method)
            && is_callable(array($this, $method))
        ) {
            return call_user_func_array([$this, 'scope' . ucfirst($name)], $arguments);
        }
    }

    private function scopeAdd($event, $action, $settings = [])
    {
        $this->subscribe->addAction($event, $action, $settings);
        return $this;
    }

    private function scopeAddEvent($name, $namespace)
    {
        $this->subscribe->addEvent($name, $namespace);
        return $this;
    }

    private function scopeAddProperty($name, $namespace)
    {
        $this->subscribe->addProperty($name, $namespace);
        return $this;
    }
    private function scopeListen($events){

       $data=$this->subscribe->getAll()->getData();
       foreach ($data as $key=>$datum){
           foreach ($datum as  $fname=>$fsettings){
                   $events->listen($key,$fname);
               }
       }
       return $events;

    }
    private function scopeGetForm($namespace){
        $namespaceExploade=explode('@',$namespace);
        $class=$namespaceExploade[0];
        $method=$namespaceExploade[1].'Form';
        $obj=new $class;
        if (method_exists($obj, $method) && is_callable(array($obj, $method))){
            return call_user_func_array([$obj,$method],[]);
        }
        return [];
    }
    private function scopeClean($event,$function){
       return $this->subscribe->getAll()->cleaner($event,$function);
    }
}
