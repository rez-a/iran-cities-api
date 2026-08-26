<?php

namespace Iran\Services;



class CacheService
{
    private string $cachePath;

    public function __construct(){
        $this->cachePath = dirname(__DIR__ , 2) . '/storage/cache';
    }

    private function getFilePath(string $key): string
    {
        $filename = hash('sha256', $key);
        return "{$this->cachePath}/{$filename}.json";
    }

    public function set(string $key , mixed $data , int $ttl = 3600):void{
        $file = $this->getFilePath($key);
        $cache = [
            'key'=>$key,
            'expire_at' => time() + $ttl,
            'data' => $data
        ];
        file_put_contents($file, json_encode($cache));
    }

    public function get(string $key):mixed{
        $file = $this->getFilePath($key);
        if(!file_exists($file)){
            return null;
        }
        $cache = json_decode(file_get_contents($file), true);
        if($cache['expire_at'] < time()){
            unlink($file);
            return null;
        }
        return $cache['data'];
    }

    public function clearByPrefix(string $prefix):void
    {
        $files = glob($this->cachePath . '/*.json');
        foreach($files as $file){
            $cache = json_decode(file_get_contents($file), true);
            if(isset($cache['key']) && str_starts_with($cache['key'], $prefix)){
                unlink($file);
            }
        }

    }

}
