<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Info(
 *     title="Translation API",
 *     version="1.0.0",
 *     description="API for managing translations in the system.",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     )
 * )
 */
class TranslationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="List all translations",
     *     tags={"Translations"},
     *     responses={
     *         @OA\Response(
     *             response=200,
     *             description="A list of translations",
     *             @OA\JsonContent(
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Translation")
     *             )
     *         ),
     *         @OA\Response(response=500, description="Server error")
     *     }
     * )
     */
    public function index()
    {
        try {
            $translations = Translation::all();

            return response()->json($translations);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to fetch translations',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"key", "content", "locale"},
     *                 @OA\Property(property="key", type="string", example="hello"),
     *                 @OA\Property(property="content", type="string", example="Hello"),
     *                 @OA\Property(property="locale", type="string", example="en"),
     *                 @OA\Property(property="tags", type="array", items={@OA\Items(type="string")})
     *             )
     *         )
     *     },
     *     responses={
     *         @OA\Response(response=200, description="Translation created successfully"),
     *         @OA\Response(response=400, description="Invalid input"),
     *         @OA\Response(response=500, description="Server error")
     *     }
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'locale'  => 'required|string',
                'key'     => 'required|string|unique:translations,key',
                'content' => 'required|string',
                'tags'    => 'array',
            ]);

            $translation = Translation::create($data);

            return response()->json($translation, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to create translation',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     summary="Update an existing translation",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"content"},
     *                 @OA\Property(property="content", type="string", example="Updated content")
     *             )
     *         )
     *     },
     *     responses={
     *         @OA\Response(response=200, description="Translation updated successfully"),
     *         @OA\Response(response=404, description="Translation not found"),
     *         @OA\Response(response=500, description="Server error")
     *     }
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'locale'  => 'sometimes|string',
                'key'     => 'sometimes|string|unique:translations,key,' . $id,
                'content' => 'sometimes|string',
                'tags'    => 'sometimes|array',
            ]);

            $translation = Translation::findOrFail($id);
            $translation->update($data);

            return response()->json($translation);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error'   => 'Translation not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to update translation',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/translations/{id}",
     *     summary="Get a single translation",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation",
     *         @OA\Schema(type="integer")
     *     ),
     *     responses={
     *         @OA\Response(response=200, description="The requested translation",
     *             @OA\JsonContent(ref="#/components/schemas/Translation")),
     *         @OA\Response(response=404, description="Translation not found"),
     *         @OA\Response(response=500, description="Server error")
     *     }
     * )
     */
    public function show(Translation $translation)
    {
        try {
            return response()->json($translation);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to fetch translation',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/translations/search",
     *     operationId="searchTranslations",
     *     tags={"Translations"},
     *     summary="Search translations",
     *     description="Search translations by tag, key, or content.",
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="Filter by tag (must match an item in the JSON 'tags' array)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="Search by key (partial match)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Search by content (partial match)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of matching translations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="locale", type="string", example="en"),
     *                 @OA\Property(property="key", type="string", example="greeting"),
     *                 @OA\Property(property="content", type="string", example="Hello"),
     *                 @OA\Property(property="tags", type="array", @OA\Items(type="string"), example={"common", "welcome"}),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to search translations",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to search translations"),
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        try {
            $query = Translation::query();

            if ($request->has('tag')) {
                $query->whereJsonContains('tags', $request->tag);
            }

            if ($request->has('key')) {
                $query->where('key', 'like', '%' . $request->key . '%');
            }

            if ($request->has('content')) {
                $query->where('content', 'like', '%' . $request->content . '%');
            }

            $results = $query->get();

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to search translations',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
