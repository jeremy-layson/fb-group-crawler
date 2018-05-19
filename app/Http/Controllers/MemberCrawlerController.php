<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\GroupMember;

class MemberCrawlerController extends Controller
{

    private $member;

    public function __construct(GroupMember $member)
    {
        $this->member = $member;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('group_member_crawler');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rawData = html_entity_decode($request->get('text'));
        $cursor = $this->getCursor($rawData);

        // clean members settings
        $data = str_replace('aria-label=\"Member Settings\"', '', $rawData);

        // explode by names
        
        $data = explode('aria-label=\"', $data);

        // crawl data and separate names and join date
        try {
            $data = $this->cleanData($data);
            
        } catch (Exception $e) {
            var_dump($e);
            exit();
        }

        return json_encode(['data' => $data, 'cursor' => $cursor]);
    }

    private function createData($name, $fb, $joinDate)
    {
        $data = $this->member->firstOrCreate([
            'member_name' => $name,
        ]);

        $data->fb_group_id = substr('SSS Hub', 0, 50);
        $data->fb_member_id = substr($fb, 0, 50);
        $data->member_name = substr($name, 0, 150);
        $data->join_date = $joinDate;

        return $data->save();
    }

    private function cleanData($data)
    {
        $cleanData = [];
        foreach ($data as $key => $value) {
            if (strpos($value, 'for (;;)') !== FALSE) {
                continue;
            }

            $endPosition = strpos($value, '\"');

            $name = substr($value, 0, $endPosition);


            if (strpos($value, "Joined") !== FALSE) {
                // find title=\"Friday, May 4, 2018 at 11:03am\"
                
                $start = strrpos($value, 'title=\"') + 8;
                $end = strpos($value, '\"', $start);
                $date = substr($value, $start, $end - $start);
                $date = str_replace(' at', ', ', $date);
                $date = Carbon::parse($date);
            } elseif ((strpos($value, 'Today') !== FALSE) || (strpos($value, 'Yesterday') !== FALSE)) {
                $date = Carbon::now()->startOfDay();
            } else {
                // Format: Added by Abi Adino Francisco on August 24, 2017
                $start = strpos($value, ' on ') + 4;
                $end = strpos($value, '\u003C\/div>\u003Cdiv class=\"_60rj\\', $start);
                $date = substr($value, $start, $end - $start);
                $date = Carbon::parse($date);
            }

            $fbId = $this->getFbId($value);;

            //get FB ID

            $date = $date->toDateTimeString();

            $cleanData[] = [$name, $date, $fbId];

            $this->createData($name, $fbId, $date);
        }

        return $cleanData;
    }

    private function getFbId($data)
    {
        $needle = 'u003Ca href=\"https:\/\/www.facebook.com\/';
        $start = strpos($data, $needle) + strlen($needle);

        if (strpos($data, 'profile.php') !== FALSE) {
            $end = strpos($data, '&', $start);
        } else {
            $end = strpos($data, '?fref=gm', $start);
        }

        return substr($data, $start, $end - $start);
    }

    private function getCursor($data)
    {
        $start = strpos($data, 'all_members&cursor=') + 19;
        $end = strpos($data, '&', $start);

        return substr($data, $start, $end - $start);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
