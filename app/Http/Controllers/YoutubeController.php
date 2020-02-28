<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


class YoutubeController extends Controller
{
	/**
     * @var string
     */
    protected $youtube_key; // from the config file

    /**
     * @var array
     */
    public $APIs = [
        'categories.list' => 'https://www.googleapis.com/youtube/v3/videoCategories',
        'videos.list' => 'https://www.googleapis.com/youtube/v3/videos',
        'search.list' => 'https://www.googleapis.com/youtube/v3/search',
        'channels.list' => 'https://www.googleapis.com/youtube/v3/channels',
    ];
	
	  /**
     * @var array
     */
    public $page_info = [];

	/**
     * Constructor
     * $youtube = new Youtube(['key' => 'KEY HERE'])
     *
     * @param string $key
     * @throws \Exception
     */
    public function __construct()
    {
		$key = env('YOUTUBE_API_KEY');
        if (is_string($key) && !empty($key)) {
            $this->youtube_key = $key;
        } else {
            throw new \Exception('Google API key is Required, please visit https://console.developers.google.com/');
        }
    }
	
	/**
     * @param $name
     * @return mixed
     */
    public function getApi($name)
    {
        return $this->APIs[$name];
    }
	
	/**
     * Using CURL to issue a GET request
     *
     * @param $url
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = $this->youtube_key;

        //boilerplates for CURL
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
        if (strpos($url, 'https') === false) {
            curl_setopt($tuCurl, CURLOPT_PORT, 80);
        } else {
            curl_setopt($tuCurl, CURLOPT_PORT, 443);
        }

        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
        $tuData = curl_exec($tuCurl);
        if (curl_errno($tuCurl)) {
            throw new \Exception('Curl Error : ' . curl_error($tuCurl));
        }

        return $tuData;
    }


	/**
     * Gets popular videos for a specific region (ISO 3166-1 alpha-2)
     *
     * @param $regionCode
     * @param integer $maxResults
     * @param array $part
     * @return array
     */
    public function getPopularVideos($regionCode, $maxResults = 10, $part = ['id', 'snippet', 'contentDetails', 'player', 'statistics', 'status'])
    {
        $API_URL = $this->getApi('videos.list');
        $params = [
            'chart' => 'mostPopular',
            'part' => implode(', ', $part),
            'regionCode' => $regionCode,
            'maxResults' => $maxResults,
        ];

        $apiData = $this->api_get($API_URL, $params);

        return $this->decodeList($apiData);
    }

    /**
     * Simple search interface, this search all stuffs
     * and order by relevance
     *
     * @param $q
     * @param integer $maxResults
     * @param array $part
     * @return array
     */
    public function searchVideo($q, $maxResults = 10, $part = ['id', 'snippet'])
    {
        $params = [
            'q' => $q,
            'part' => implode(', ', $part),
            'maxResults' => $maxResults,
        ];

        return $this->searchAdvanced($params);
    }
	
	 /**
	 *Generic Search interface, use any parameters specified in
     * the API reference
     *
     * @param $params
     * @param $pageInfo
     * @return array
     * @throws \Exception
     */
    public function searchAdvanced($params, $pageInfo = false)
    {
        $API_URL = $this->getApi('search.list');

        if (empty($params) || (!isset($params['q']) && !isset($params['channelId']) && !isset($params['videoCategoryId']))) {
            throw new \InvalidArgumentException('at least the Search query or Channel ID or videoCategoryId must be supplied');
        }

        $apiData = $this->api_get($API_URL, $params);
        if ($pageInfo) {
            return [
                'results' => $this->decodeList($apiData),
                'info' => $this->page_info,
            ];
        } else {
            return $this->decodeList($apiData);
        }
    }

	/**
     * Decode the response from youtube, extract the list of resource objects
     *
     * @param  string $apiData response string from youtube
     * @throws \Exception
     * @return array Array of StdClass objects
     */
    public function decodeList(&$apiData)
    {
        $resObj = json_decode($apiData);
        if (isset($resObj->error)) {
            $msg = "Error " . $resObj->error->code . " " . $resObj->error->message;
            if (isset($resObj->error->errors[0])) {
                $msg .= " : " . $resObj->error->errors[0]->reason;
            }

            throw new \Exception($msg);
        } else {
            $this->page_info = [
                'resultsPerPage' => $resObj->pageInfo->resultsPerPage,
                'totalResults' => $resObj->pageInfo->totalResults,
                'kind' => $resObj->kind,
                'etag' => $resObj->etag,
                'prevPageToken' => null,
                'nextPageToken' => null,
            ];

            if (isset($resObj->prevPageToken)) {
                $this->page_info['prevPageToken'] = $resObj->prevPageToken;
            }

            if (isset($resObj->nextPageToken)) {
                $this->page_info['nextPageToken'] = $resObj->nextPageToken;
            }

            $itemsArray = $resObj->items;
            if (!is_array($itemsArray) || count($itemsArray) == 0) {
                return false;
            } else {
                return $itemsArray;
            }
        }
    }


	public function index(){
    // Get popular videos in a country, return an array of PHP objects
	$results = self::getPopularVideos(env('YOUTUBE_REGION'));
	
	return view('welcome', ['results'=>$results]);
	}
	
	public function search(Request $request){
		
		//Search playlists, channels and videos. return an array of PHP objects
		$search_term = $request->search;
		$results = self::searchVideo($search_term);
		
		return view('search', ['results'=>$results, 'old_search'=>$search_term]);
	}
	
	public function redirect(){
			
		return self::index();	
	}
}
