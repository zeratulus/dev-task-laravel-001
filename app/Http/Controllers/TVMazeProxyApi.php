<?php

namespace App\Http\Controllers;

use App\Cache\JsonCache;
use Illuminate\Http\Request;

class TVMazeProxyApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Sorry for a delay, relocation to new place and a lot of bombs from russians on this week... =[
        //PS. There is no pagination data in response from api.tvmaze.com/search/shows -> example data that im research: https://api.tvmaze.com/search/shows?q=girls
        //I`m really do not know what need to be tested here

        $cache = new JsonCache();

        $results = [];

        if ($cache->has($id)) {
            $results = $cache->get($id);
        } else {
            $endpoint = "https://api.tvmaze.com/search/shows?q=$id";

            $json = file_get_contents($endpoint);
            $data = json_decode($json, true);

            foreach ($data as $show) {
                if (strtolower($show['show']['name']) == strtolower($id)) {
                    $results[] = $show;
                }
            }

            $cache->set($id, $results);
        }

        return $results;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
