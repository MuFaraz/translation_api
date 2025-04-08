<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->filled('key')) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        if ($request->filled('locale')) {
            $query->where('locale', $request->locale);
        }

        return response()->json($query->paginate(20), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'locale' => 'required|string',
            'value' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        $translation = Translation::updateOrCreate(
            ['key' => $data['key'], 'locale' => $data['locale']],
            ['value' => $data['value'], 'tags' => $data['tags'] ?? []]
        );

        return response()->json($translation, 201);
    }

    public function update(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($request->only('value', 'tags'));

        return response()->json($translation, 200);
    }

    public function export($locale)
    {
        $translations = Translation::where('locale', $locale)->get();

        $result = $translations->pluck('value', 'key');

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
