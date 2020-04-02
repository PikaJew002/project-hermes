<?php

namespace App\Http\Controllers\Api;

use App\Family;
use App\Http\Controllers\Controller;
use App\Http\Resources\Family as FamilyResource;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* authorization */
        $this->authorize('viewAny', Family::class);

        $families = Family::all();
        /* return resource collection */
        return FamilyResource::collection($families);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* validation */
        $request->validate([
          'name' => 'required|string',
          'admin_id' => 'integer',
        ]);
        /* create new model */
        $family = new Family;
        $family->admin_id = $request->user()->id;
        /* authorization */
        $request->authorize('create', $family);
        /* populate model */
        $family->name = $request->input('name');
        /* save model */
        if($family->save()) {
            /* return resource */
            return new FamilyResource($family);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        /* authorization */
        $this->authorize('view', $family);
        /* return resource */
        return new FamilyResource($family);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Family $family)
    {
        /* validation */
        $request->validate([
          'id' => 'required|integer',
          'admin_id' => 'required|integer',
          'name' => 'required|string',
        ]);
        /* authorization */
        $request->authorize('update', $family);
        /* update model */
        // Intros a possible concept for ownership change
        $family->admin_id = $request->input('admin_id');
        $family->name = $request->input('name');
        /* save model */
        if($family->save()) {
            /* return resource */
            return new FamilyResource($family);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        /* authorization */
        $request->authorize('update', $family);
        /* delete model */
        if($family->delete()) {
            /* return resource */
            return new FamilyResource($family);
        }
    }
}
