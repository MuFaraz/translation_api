<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="List all translations",
     *     tags={"Translations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="key", in="query", description="Filter by key", @OA\Schema(type="string")),
     *     @OA\Parameter(name="tag", in="query", description="Filter by tag", @OA\Schema(type="string")),
     *     @OA\Parameter(name="locale", in="query", description="Filter by locale", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="List of translations"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->filled('key')) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tag', $request->tag);
        }

        if ($request->filled('locale')) {
            $query->where('locale', $request->locale);
        }

        return response()->json($query->paginate(20), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create or update a translation",
     *     tags={"Translations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"key", "locale", "value"},
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(property="locale", type="string"),
     *             @OA\Property(property="value", type="string"),
     *             @OA\Property(property="tag", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Translation created or updated"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'locale' => 'required|string',
            'value' => 'required|string',
            'tag' => 'nullable|string'
        ]);

        $translation = Translation::updateOrCreate(
            ['key' => $data['key'], 'locale' => $data['locale']],
            ['value' => $data['value'], 'tag' => $data['tag'] ?? []]
        );

        return response()->json($translation, 201);
    }
    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     summary="Update a translation",
     *     tags={"Translations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="value", type="string"),
     *             @OA\Property(property="tag", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Translation updated"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Translation not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($request->only('value', 'tag'));

        return response()->json($translation, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/translations/export/{locale}",
     *     summary="Export translations by locale",
     *     tags={"Translations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="locale", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Exported translations"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function export($locale)
    {
        $translations = Translation::where('locale', $locale)->get();

        $result = $translations->pluck('value', 'key');

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
