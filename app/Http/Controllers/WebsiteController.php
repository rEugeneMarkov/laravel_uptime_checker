<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Frequency;
use App\Services\CheckWebsiteService;
use App\Http\Requests\WebsiteStoreRequest;
use App\Http\Requests\WebsiteUpdateRequest;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::where('user_id', '=', auth()->user()->id)->get();
        return view('personal.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $frequencies = Frequency::all();
        return view('personal.create', compact('frequencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebsiteStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Website::firstOrCreate($data);

        return redirect()->route('personal.website.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {
        return view('personal.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        $frequencies = Frequency::all();
        return view('personal.edit', compact('website', 'frequencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebsiteUpdateRequest $request, Website $website)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $website->update($data);

        return redirect()->route('personal.website.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        $website->delete();
        return redirect()->route('personal.website.index');
    }

    public function activate(Website $website)
    {
        $a = new CheckWebsiteService($website);
        $a->chengeCheckStatus();

        return redirect()->route('personal.website.show', compact('website'));
    }
}
