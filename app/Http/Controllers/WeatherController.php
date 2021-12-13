<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\WeatherApiService;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $request = request()->all();
        $cityQ = $request['city'];
        $weatherService = new WeatherApiService();

        // city key logic
        $cityKey = "";
        if (Cache::get('key_' . $cityQ)) {
            $cityKey = Cache::get('key_' . $cityQ);
        } else {
            $keyRes = $weatherService->getCityKey($request['city']);
            if (!$keyRes) {
                return response()->json(['success' => true, 'message' => 'Key not found'], 404);
            }

            $cityKey = Cache::remember("key_" . $cityQ, 60 * 60 * 24, function () use ($keyRes) {
                return $keyRes;
            });
        }

        // current weather Logic
        $currentTemp = null;
        if (Cache::has('current_temperature_' . $cityKey)) {
            $currentTemp = Cache::get('current_temperature_' . $cityKey);
        } else {
            $currentTempRes = $weatherService->getCurrentTemperature($cityKey);
            
            $currentTemp = Cache::remember("current_temperature_" . $cityKey, 60 * 60, function () use ($currentTempRes) {
                return $currentTempRes;
            });
            
        }

        // 5 day forecast 
        $forecastTemp = null;
        if (Cache::get('forecast_' . $cityKey)) {
            $forecastTemp = Cache::get('forecast_' . $cityKey);
        } else {
            $forecastTempRes = $weatherService->getForecast($cityKey);
            
            $forecastTemp = Cache::remember("forecast_" . $cityKey, 60 * 60 * 24, function () use ($forecastTempRes) {
                return $forecastTempRes;
            });
            
        }

        return response()->json(['success' => true, 'current_temperature' => $currentTemp, "forecast" => $forecastTemp], 200);
    }
}
