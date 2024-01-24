<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalenderController extends Controller
{
	public function index()
    {
        return Calender::all();
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
        $new_Calender = Calender::create($request->all());
        return response()->json([
            'data' => new Calender($new_Calender),
            'message' => 'Successfully added new event!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calender  $Calender
     * @return \Illuminate\Http\Response
     */
    public function show(Calender $Calender)
    {
        return response($Calender, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Calender  $Calender
     * @return \Illuminate\Http\Response
     */
    public function edit(Calender $Calender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calender  $Calender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calender $Calender)
    {
        $Calender->update($request->all());
        return response()->json([
            'data' => new Calender(),
            'message' => 'Successfully updated event!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calender  $Calender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calender $Calender)
    {
        $Calender->delete();
        return response('Event removed successfully!', Response::HTTP_NO_CONTENT);
    }
}
