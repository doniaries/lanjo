<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Get gallery items.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 20);
        $tagSlug = $request->query('tag_slug');
        $tagSlugs = $request->query('tag_slugs');

        $query = Gallery::query();

        if ($tagSlug) {
            $query->whereHas('tags', function ($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        } elseif ($tagSlugs) {
            $slugs = explode(',', $tagSlugs);
            $query->whereHas('tags', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        $galleries = $query->latest('published_at')
            ->paginate($limit);

        // Append URLs for each item
        $galleries->getCollection()->transform(function ($gallery) {
            $gallery->thumbnail_url = $gallery->thumbnail_url;
            $gallery->image_urls = $gallery->image_urls;
            return $gallery;
        });

        return response()->json([
            'success' => true,
            'message' => 'Galleries retrieved successfully',
            'data' => $galleries
        ]);
    }

    /**
     * Get single gallery detail.
     */
    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)->firstOrFail();

        $gallery->thumbnail_url = $gallery->thumbnail_url;
        $gallery->image_urls = $gallery->image_urls;

        return response()->json([
            'success' => true,
            'message' => 'Gallery detail retrieved successfully',
            'data' => $gallery
        ]);
    }
}
