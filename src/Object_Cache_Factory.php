<?php

namespace Claxifieds\Cache;

	/**
	 * Class Object_Cache_Factory
	 */
	class Object_Cache_Factory {

		private static $instance;
        
        /**
         * @return \Object_Cache_default|null
         * @throws \Exception
         */
		public static function newInstance()
    {
        if( self::$instance == null ) {
            self::$instance = self::getCache();
        }
        return self::$instance;
    }

		/**
		 * @return null|\Object_Cache_default
		 * @throws \Exception
		 */
		public static function getCache() {
		    
        if(self::$instance == null) {
            $cache = 'default';
            if( defined('OSC_CACHE') ) {
                $cache = OSC_CACHE;
            }

            $filename = 'Object_Cache_'.$cache;
            $cache_class = sprintf(__NAMESPACE__.'\\Object_Cache_%s', $cache);
	        $file        = __DIR__ . DIRECTORY_SEPARATOR . $filename . '.php';

            if(file_exists($file)) {
                if(class_exists($cache_class)) {
                    if( call_user_func(array($cache_class, 'is_supported')) ) {

                        self::$instance = new $cache_class();
                    } else {
                        self::$instance = new Object_Cache_default();
                        error_log('Cache '. $cache .' NOT SUPPORTED - loaded Object_Cache_default cache');
                    }
                    return self::$instance;
                }
            }
	        throw new \RuntimeException( 'Unknown cache' );
        } else {
            return self::$instance;
        }
    }
}
