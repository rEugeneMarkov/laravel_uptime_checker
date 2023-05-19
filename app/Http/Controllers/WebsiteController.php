<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Http\Requests\WebsiteStoreRequest;
use App\Http\Requests\WebsiteUpdateRequest;
use App\Helpers\WebsiteControllerShowHelper;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::where('user_id', '=', auth()->user()->id)
            ->orderByDesc('id')
            ->paginate(20);
        return view('personal.website.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personal.website.create');
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
    public function show(Website $website, WebsiteControllerShowHelper $helper)
    {
        $data = $helper->getShowData($website);
        $avgExecTime = $data['avg_execution_time'];
        $dashChartData = $data['dashChartData'];
        $uptimeChartData = $data['uptimeChartData'];
        return view('personal.website.show', compact('website', 'dashChartData', 'avgExecTime', 'uptimeChartData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        return view('personal.website.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebsiteUpdateRequest $request, Website $website)
    {
        $data = $request->validated();
        $website->update($data);

        return redirect()->route('personal.website.show', compact('website'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        $website->delete();
        return redirect()->route('personal.website.index');
    }
}
