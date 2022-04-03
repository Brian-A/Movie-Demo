<?php


class TMDB {
    public $apiKey = '';
    public $lastResponse = false;

    // Don't edit this file manually as changes will be blown away
    private $cachedConfigFileName =  __DIR__ . DIRECTORY_SEPARATOR . "tmdb-config-cache.json";

    function __construct($apiKey){
        $this->apiKey = $apiKey;
    }
    function getRequest($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
    public function getMovies($page = 1){
        $response = $this->getRequest("https://api.themoviedb.org/3/movie/popular?api_key={$this->apiKey}&page={$page}");
        if($response){
            $response = json_decode($response, true);
            $this->lastResponse = $response;
        } else{
            $response = false;
        }

        return $response;
    }

    public function getMovie($id){
        $response = $this->getRequest("https://api.themoviedb.org/3/movie/$id?api_key={$this->apiKey}");
        if($response){
            $response = json_decode($response, true);
            $this->lastResponse = $response;
        } else{
            $response = false;
        }
        return $response;
    }
    public function searchMovies($query = '', $page = 1){

        $response = $this->getRequest("https://api.themoviedb.org/3/search/movie?api_key={$this->apiKey}&page={$page}&query={$query}");

        if($response){
            $response = json_decode($response, true);

            $this->lastResponse = $response;
        } else{
            $response = false;
        }
        return $response;

    }


    public function getConfigurationData(){
        // Make sure there's a local copy of config and if not call updateConfigurationData to create it
        $config = false;
        if(!file_exists($this->cachedConfigFileName)){
            $config = $this->updateConfigurationData();
        } else{
            $config = json_decode(file_get_contents($this->cachedConfigFileName), true);
        }
        return $config;
    }

    public function updateConfigurationData(){
        // Update the cached record of API's configuration data
        $response = $this->getRequest("https://api.themoviedb.org/3/configuration?api_key={$this->apiKey}");
        $config = json_decode($response, true);
        // Do some basic validation as we don't want a failed request to break our config cache
        if(array_key_exists('images', $config) && array_key_exists('base_url', $images = $config['images'] )){
            file_put_contents($this->cachedConfigFileName , $response);
            return $config;
        }
    }

    public function getPagination($count = 9, $response = false){
        if(!$response) $response = $this->lastResponse;
        $page = false;
        $totalPages = false;
        $result = [];
        if(array_key_exists('page', $response)) $page = $response['page'];
        if(array_key_exists('total_pages', $response)) $totalPages = $response['total_pages'];
        if($totalPages > 500) $totalPages = 500; // API hard limit
        if($totalPages <= $count ){
            // If there's not many items
            for($i = 0; $i < $totalPages; $i++){
                $result[] = $i + 1;
            }
        } else{
            $start = ($page - 1 > 0) ? $page-1 : $page;
            $end = $start + $count;
            $end = ($end > $totalPages) ? $totalPages : $end;
            for($i = $start; $i < $end; $i++){
                $result[] = $i;
            }
            // Try to get $count items as if we're approaching $totalPages we may have too few
            if(count($result) < $count){
                $i = $start;
                while(count($result) < $count && $i > 1){
                    $i--;
                    array_unshift($result,$i);
                }
            }
        }

        return [
            "pageNumbers" =>  $result,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ];
    }


}