<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherApiService
{
    public function getCityKey($city)
    {
        $apiKey = env('WEATHER_KEY', false);

        if ($apiKey) {
            $response = Http::get('http://dataservice.accuweather.com/locations/v1/cities/search?apikey=' . $apiKey . '&q=' . $city);
            if (isset($response[0]["Key"])) {
                return $response[0]["Key"];
            }

            return null;
        }

        return null;
    }

    public function getCurrentTemperature($cityKey)
    {
        $apiKey = env('WEATHER_KEY', false);
        if ($apiKey) {
            $response = Http::get('http://dataservice.accuweather.com/currentconditions/v1/' . $cityKey . '?apikey=' . $apiKey);
            if ($response[0]["Temperature"]) {
                return $response[0]["Temperature"];
            }

            return null;
        }

        return null;
    }

    public function getForecast($cityKey)
    {
        $apiKey = env('WEATHER_KEY', false);
        if ($apiKey) {
            $response = Http::get('http://dataservice.accuweather.com/forecasts/v1/daily/5day/' . $cityKey . '?apikey=' . $apiKey);
            if ($response["DailyForecasts"]) {
                return $response["DailyForecasts"];
            }
            return null;
        }

        return null;
    }
}
