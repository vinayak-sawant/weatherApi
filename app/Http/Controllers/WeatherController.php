<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weather;

class WeatherController extends Controller
{
    public function index()
    {
        $weatherData = Weather::latest()->get();
   
        return view('home', compact('weatherData'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'city' => 'required'
        ]);
        
        $urlContents = $this->curl("http://api.openweathermap.org/data/2.5/weather?q=".$request->city."&type=accurate&appid=eebe2b4502ac871a2dbc80b089a30418");

        // print_r(json_encode($urlContents));
        // exit();
        
        $weatherArray = json_decode($urlContents, true);

        if ($weatherArray['cod'] === 200) {
        	$weatherData['date'] = gmdate("Y-m-d", $weatherArray['dt']);
	        $weatherData['city'] = $weatherArray['name'];

	        if (Weather::where('city', '=', $weatherArray['name'])->where('date', '=', $weatherData['date'])->exists()) {
	        	$weather = Weather::where('city', '=', $weatherArray['name'])->where('date', '=', $weatherData['date'])->first();
		   		$weather->weather_id = $weatherArray['weather'][0]['id'];
		        $weather->main = $weatherArray['weather'][0]['main'];
		        $weather->description = $weatherArray['weather'][0]['description'];
		        $weather->icon = $weatherArray['weather'][0]['icon'];
		   		$weather->save();

		   		return redirect('/home')
	             ->with('success', 'Weather data updated Successfully!');
	        }
	        else {
	        	$weatherData['weather_id'] = $weatherArray['weather'][0]['id'];
		        $weatherData['main'] = $weatherArray['weather'][0]['main'];
		        $weatherData['description'] = $weatherArray['weather'][0]['description'];
		        $weatherData['icon'] = $weatherArray['weather'][0]['icon'];
		        Weather::create($weatherData);

		        return redirect('/home')
	             ->with('success', 'Weather data stored Successfully!');
	        }
	       	
        }
        else {
        	return redirect('/home')
             ->with('error', $weatherArray['message']);
        }     
    }

    function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    } 
}
