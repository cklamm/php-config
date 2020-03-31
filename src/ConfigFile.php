<?php namespace cklamm\Config;

use Exception;

class ConfigFile
{
    protected $data = [];

    public function __construct(string $file)
    {
        ob_start();
        $this->data = require $file;
        ob_end_clean();

        if (!is_array($this->data)) {
            throw new Exception('Config file must return an array: ' . $file);
        }
    }

    public function get(string $name)
    {
        if ($name == '*') return $this->data;

        if (isset($this->data[$name])) return $this->data[$name];

        if (!preg_match('#\.\*$#', $name)) return null;

        $regex = '#^' . preg_quote(rtrim($name, '*')) . '#';
        $result = [];

        foreach ($this->data as $key => $val) {
            if (!preg_match($regex, $key)) continue;
            $key = preg_replace($regex, '', $key);
            $result[$key] = $val;
        }

        return $result;
    }
}
