<?php namespace cklamm\Config;

class ConfigFile
{
    protected $data = [];

    public function __construct(string $file)
    {
        $this->data = require $file;
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
