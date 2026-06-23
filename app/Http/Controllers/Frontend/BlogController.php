<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['category', 'tags', 'media'])
            ->published()
            ->latest('published_at')
            ->paginate(14);

        return view('blog', compact('posts'));
    }

    public function show(Post $post): View
    {
        abort_if(! $post->isPublished() && ! auth()->check(), 404);

        $post->load(['category', 'tags', 'media']);

        return view('blog.show', compact('post'));
    }

    public function category(Category $category): View
    {
        $posts = $category->posts()
            ->with(['category', 'tags', 'media'])
            ->published()
            ->latest('published_at')
            ->paginate(14);

        return view('blog', compact('posts', 'category'));
    }

    public function tag(Tag $tag): View
    {
        $posts = $tag->posts()
            ->with(['category', 'tags', 'media'])
            ->published()
            ->latest('published_at')
            ->paginate(14);

        return view('blog', compact('posts', 'tag'));
    }
}
