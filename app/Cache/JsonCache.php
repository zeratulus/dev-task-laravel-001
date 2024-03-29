<?php

namespace App\Cache;

use Illuminate\Support\Facades\Config;

class JsonCache
{
    /**
     * Seconds to cache expires
     * @var int
     */
    private int $expire;

    private string $path;
    private string $file;

    private array $data = [];

    public function __construct(int $expire = 86400)
    {
        $this->path = Config::get('cache.stores.file.path');
        $this->file = $this->path . DIRECTORY_SEPARATOR . 'json-cache.json';

        $this->expire = $expire;

        if (file_exists($this->file)) {
            $time = filectime($this->file) + $this->expire;
            if ($time <= time()) {
                unlink($this->file);
            } else {
                $this->data = json_decode(file_get_contents($this->file), true) ?? [];
            }
        }
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function get(string $key): mixed
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return false;
    }

    public function set(string $key, mixed $value): bool
    {
        $this->delete($key);

        $this->data[$key] = $value;

        return true;
    }

    public function delete(string $key): int
    {
        if ($this->get($key)) {
            unset($this->data[$key]);
        }

        return 1;
    }

    public function __destruct()
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777,true);
        }

        file_put_contents($this->file, json_encode($this->data));
    }
}
