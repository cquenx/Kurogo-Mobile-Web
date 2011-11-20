<?php

abstract class KurogoMemoryCache {

    // master default should be short
	protected $ttl=60; 
	protected $description;
    
	public function setTTL($ttl) {
		$this->ttl = (int) $ttl;
	}

	protected function init($args) {
		if(isset($args['CACHE_TTL'])) {
			$this->setTTL($args['CACHE_TTL']);
		}
	}

	public static function factory($cacheType, $args = array()) {
		$args = is_array($args) ? $args : array();

        if (!class_exists($cacheType)) {
            die("Cache class $cacheType not defined");
            throw new KurogoConfigurationException("Cache class $cacheType not defined");
        }

        $cacheClass = new $cacheType;
        
        if (!$cacheClass instanceOf KurogoMemoryCache) {
            throw new KurogoConfigurationException("$cacheType is not a subclass of KurogoMemoryCache");
        }

        $cacheClass->init($args);

        return $cacheClass;
	}

	abstract public function get($key);

    /* only store the value if it does not exist */
	abstract public function add($key, $value, $ttl = null);

    /* store unconditionally */
	abstract public function set($key, $value, $ttl = null);

	abstract public function delete($key);

	abstract public function clear();
	
	public function getDescription() {
	    return $this->description;
	}
	
	/* only return supported classes */
	public static function getCacheClasses() {
	    $classes = array();
	    foreach (glob(LIB_DIR . '/Cache/*') as $class) {  
	        $class =  basename($class,'.php');
	        try {
                $info = new ReflectionClass($class);
                if (!$info->isAbstract()) {
                    $cache = new $class();
                    $classes[$class] = $cache->getDescription();
                }
	        } catch (KurogoException $e) {
	        }
	    }
	    
        return $classes;       	    
	}
}