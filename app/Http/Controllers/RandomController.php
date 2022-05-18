<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Random;
use App\Models\Breakdown;

class RandomController extends Controller
{
    public function Loop(){
        $randomIteration = random_int(5, 10);
        for($i=0;$i<$randomIteration+1;$i++){
            $newRandom = new Random;
            $newRandom->values = Str::random();
            $newRandom->save();
            $LastRandomID = $newRandom->id;

            $breakdownIteration = random_int(5, 10);
            for($n=0; $n<$breakdownIteration+1; $n++){
                $newBreakdown = new Breakdown;
                $newBreakdown->values = Str::random(5);
                $newBreakdown->random_id = $LastRandomID;
                $newBreakdown->save();
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $randoms = DB::table('randoms')
            ->where('flag', false)
            ->get();
    
        if(count($randoms) <= 0) {
            $this->Loop();
            $randoms = DB::table('randoms')
            ->where('flag', false)
            ->get();
        }

        $randomIds = [];
        for ($i = 0; $i < count($randoms); $i++) {
            array_push($randomIds, $randoms[$i]->id);
        }
        $breakdowns = DB::table('breakdowns')
            ->whereIn('random_id', $randomIds)
            ->get();
        $breakDownValues = '';
        $randomValues = '';
        for ($i = 0; $i < count($breakdowns); $i++) {
            $breakDownValues .= ' '. $breakdowns[$i]->values;
        }
        for ($i = 0; $i < count($randoms); $i++) {
            $randomValues .= ' '.$randoms[$i]->values;
        }
        $response = [];
        array_push($response, $randomValues);
        array_push($response, $breakDownValues);

        DB::table('randoms')
            ->where('flag', false)
            ->update(['flag' => true]);

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
