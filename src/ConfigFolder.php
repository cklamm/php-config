<?php namespace cklamm\Config;

class ConfigFolder
{
    protected $folder;
    protected $files = [];

    public function __construct(string $folder)
    {
        $this->folder = rtrim($folder, '/') . '/';
    }

    public function get(string $name)
    {
        $parts = explode('.', $name, 2);
        if (count($parts) < 2) return null;
        $file = $parts[0];

        if (!isset($this->files[$file])) {
            $path = $this->folder . $file . '.php';
            if (!file_exists($path)) return null;
            $this->files[$file] = new ConfigFile($path);
        }

        return $this->files[$file]->get($parts[1]);
    }
}
