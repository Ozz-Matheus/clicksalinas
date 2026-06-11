<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreN8nPostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class N8nPostController extends Controller
{
    public function store(StoreN8nPostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // 1. Resolver la categoría
        $category = null;
        if (! empty($validated['category_slug'])) {
            $category = Category::where('slug', $validated['category_slug'])->first();
        }

        // 2. Generar el Slug base y asegurar que sea único
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        // 3. Crear el Post (El Ping a motores de búsqueda se disparará solo gracias a tu modelo)
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'category_id' => $category?->id,
            'user_id' => $validated['user_id'] ?? 2, // Fallback al Super Admin
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        // 4. Sincronizar Etiquetas (Crear si no existen)
        if (! empty($validated['tags'])) {
            $tagIds = collect($validated['tags'])->map(function (string $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => trim($tagName)]
                );

                return $tag->id;
            })->toArray();

            $post->tags()->sync($tagIds);
        }

        return response()->json([
            'message' => 'Post creado exitosamente',
            'post_id' => $post->id,
            'url' => $post->getIndexableUrl(),
        ], 201);
    }
}
