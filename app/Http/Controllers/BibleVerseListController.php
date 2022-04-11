<?php

namespace App\Http\Controllers;

use App\Models\BibleverseList;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Http;
class BibleVerseListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lists = [];
        if(($request->sortDesc == 'asc' || $request->sortDesc == 'desc') || ($request->sortVerse == 'asc' || $request->sortVerse == 'desc')){
            $lists = BibleverseList::where('description','LIKE','%'.$request->search.'%')->
                orWhere('verses','LIKE','%'.$request->search.'%')
                ->orderBy('verses', $request->sortVerse)
                ->orderBy('description', $request->sortDesc)
                ->get();
        } else {
            $lists = BibleverseList::where('description','LIKE','%'.$request->search.'%')
                ->orWhere('verses','LIKE','%'.$request->search.'%')
                ->get();
        }          
     
        return response($lists);
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
        $request->validate(['verses' => ['required']]);


        $response = Http::get("https://bible-api.com/" . $request->verses . "?translation=kjv");
        $verse = "";

        if($response->ok()){
            $verse = $response->json()['verses'][0]['text'];
        }
         
        $data = $request->all();
        $data['description'] = $verse; 
        return BibleverseList::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BibleverseList $bibleverseList)
    {
        // $list = BibleverseList::findOrFail($id);
        // route model binding
        return response($bibleverseList);
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
    public function update(Request $request, BibleverseList $bibleverseList)
    {
        $request->validate(['verses' => ['required']]);
        $response = Http::get("https://bible-api.com/" . $request->verses . "?translation=kjv");
        $verse = "";

        if($response->ok()){
            $verse = $response->json()['verses'][0]['text'];
        }

        $data = $request->all();
        $data['description'] = $verse; 
        $bibleverseList->update($data);
        return $bibleverseList;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BibleverseList $bibleverseList)
    {
        $bibleverseList->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
