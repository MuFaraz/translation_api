<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Translation::query()
            ->when($request->key, fn($q) => $q->where('key', 'like', "%{$request->key}%"))
            ->when($request->value, fn($q) => $q->where('value', 'like', "%{$request->value}%"))
            ->when($request->tag, fn($q) => $q->where('tag', $request->tag))
            ->paginate(50);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
            'locale' => 'required|string',
            'tag' => 'nullable|string',
        ]);

        return Translation::create($data);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($request->all());
        return $translation;
    }
    public function export($locale)
    {
        return Translation::where('locale', $locale)
            ->get()
            ->pluck('value', 'key');
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
