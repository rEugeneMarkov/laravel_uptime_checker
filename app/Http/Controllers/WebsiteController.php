<?php

namespace App\Http\Controllers;

use App\Helpers\WebsiteControllerShowHelper;
use App\Http\Requests\WebsiteStoreRequest;
use App\Http\Requests\WebsiteUpdateRequest;
use App\Models\Website;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $websites = Website::where('user_id', '=', auth()->user()->id)
            ->orderByDesc('id')
            ->paginate(20);

        return view('personal.website.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('personal.website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebsiteStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Website::firstOrCreate($data);

        return redirect()->route('personal.website.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website, WebsiteControllerShowHelper $helper): View
    {
        $data = $helper->getShowData($website);

        return view('personal.website.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website): View
    {
        return view('personal.website.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebsiteUpdateRequest $request, Website $website): RedirectResponse
    {
        $data = $request->validated();
        $website->update($data);

        return redirect()->route('personal.website.show', compact('website'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website): RedirectResponse
    {
        $website->delete();

        return redirect()->route('personal.website.index');
    }
}
