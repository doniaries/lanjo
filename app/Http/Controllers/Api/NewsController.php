<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get news items with optional tag filter.
     * Default tag is 'Pariwisata' (ID 8).
     */
    public function index(Request $request)
    {
        $tagId = $request->query('tag_id', 8);
        $tagSlug = $request->query('tag_slug');
        $limit = $request->query('limit', 20);

        $query = Post::query()
            ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->where('posts.status', 'published')
            ->whereNull('posts.deleted_at')
            ->select('posts.*')
            ->latest('posts.published_at');

        if ($tagSlug) {
            $query->join('tags', 'post_tag.tag_id', '=', 'tags.id')
                ->where('tags.slug', $tagSlug);
        } else {
            $query->where('post_tag.tag_id', $tagId);
        }

        $posts = $query->paginate($limit);

        // Append URL for each item
        $posts->getCollection()->transform(function ($post) {
            $post->foto_utama_url = $post->foto_utama_url; // Triggers accessor
            return $post;
        });

        return response()->json([
            'success' => true,
            'message' => 'News retrieved successfully',
            'data' => $posts
        ]);
    }

    /**
     * Get single news detail.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->foto_utama_url = $post->foto_utama_url;

        return response()->json([
            'success' => true,
            'message' => 'News detail retrieved successfully',
            'data' => $post
        ]);
    }
}
