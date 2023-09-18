<?php

namespace App\Models;

use Illuminate\Support\Collection;

class DataProvider
{
    protected $data;
    protected $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
        $jsonFile = storage_path("app/public/{$provider}.json");

        if (file_exists($jsonFile)) {
            $json = file_get_contents($jsonFile);
            $this->data = json_decode($json, true);
        } else {
            throw new \Exception("JSON file for provider '{$provider}' not found.");
        }
    }

    public function all()
    {
        return $this->data;
    }

    public function where($conditions)
    {
        // dd($conditions);
        $filteredData = collect($this->data);

        // $filtered->all();
        foreach ($conditions as $column => $value) {
            if ($column == 'balanceMin' || $column == 'balanceMax') {
                continue;
            }
            $filteredData = $filteredData->where($column, $value);
        }

        if (!empty($conditions['balanceMin']) && !empty($conditions['balanceMax'])) {
            if ($this->provider == "DataProviderX") {
                $filteredData = $filteredData->whereBetween('parentAmount', [$conditions['balanceMin'], $conditions['balanceMax']]);
            } elseif ($this->provider == "DataProviderY") {
                $filteredData = $filteredData->whereBetween('balance', [$conditions['balanceMin'], $conditions['balanceMax']]);
            }
        }

        return $filteredData->toArray();
    }

    public function get_status($status, $file)
    {
        $result = array();
        if ($file == "X") {
            if ($status == 'authorised') {
                $result = 1;
            } elseif ($status == 'decline') {
                $result = 2;
            } elseif ($status == 'refunded') {
                $result = 3;
            }
        } elseif ($file == "Y") {
            if ($status == 'authorised') {
                $result = 100;
            } elseif ($status == 'decline') {
                $result = 200;
            } elseif ($status == 'refunded') {
                $result = 300;
            }
        }

        return $result;
    }
}
