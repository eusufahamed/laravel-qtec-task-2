<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Url;

class UrlController extends Controller
{
    public function create()
    {
        return view('url.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        // Check if the URL already exists in the database
        $existingUrl = Url::where('original_url', $request->input('original_url'))->first();

        if ($existingUrl) {
            return redirect()->route('url.create')->with([
                'original' => $existingUrl->original_url,
                'shortened' => $existingUrl->shortened_url,
                'message' => 'This URL has already been shortened.',
            ]);
        }

        // If not, create a new short URL
        $url = Url::create([
            'user_id' => Auth::id(),
            'original_url' => $request->input('original_url'),
            'shortened_url' => $this->generateShortUrl($request->input('original_url')),
        ]);

        return redirect()->route('url.create')->with([
            'original' => $url->original_url,
            'shortened' => $url->shortened_url
        ]);
    }

    public function redirect($shortenedUrl)
    {
        $url = Url::where('shortened_url', $shortenedUrl)->first();

        if ($url) {
            // Increment the click count
            $url->increment('click_count');

            return redirect($url->original_url);
        }

        abort(404);
    }

    private function generateShortUrl($originalUrl)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $base = strlen($characters);

        // Generate a unique short URL based on timestamp and the hash of the original URL
        $timestamp = base_convert(time(), 10, $base);
        $hash = base_convert(crc32($originalUrl), 10, $base);

        // Append random characters to the timestamp and hash to ensure uniqueness
        $randomPart = '';
        for ($index = 0; $index < 4; $index++) {
            $randomPart .= $characters[rand(0, $base - 1)];
        }

        $shortUrl = $timestamp . $hash . $randomPart;

        // Check if the generated short URL already exists
        while (Url::where('shortened_url', $shortUrl)->exists()) {
            // If it exists, regenerate the short URL
            $timestamp = base_convert(time(), 10, $base);
            $hash = base_convert(crc32($originalUrl), 10, $base);
            $randomPart = '';
            for ($index = 0; $index < 4; $index++) {
                $randomPart .= $characters[rand(0, $base - 1)];
            }
            $shortUrl = $timestamp . $hash . $randomPart;
        }

        return $shortUrl;
    }

    public function clickCount(Request $request)
    {   
        $urlId = $request->input('urlId');

        // Find the URL by its ID
        $url = Url::find($urlId);

        if (!$url) {
            return response()->json([
                'error' => 'URL not found'
            ], 404);
        }

        return response()->json([
            'clickCount' => $url->click_count,
        ]);

    }

    public function showStatistic()
    {
        $user = Auth::user();
        $urls = $user->urls;

        return view('url.statistic', ['urls' => $urls]);
    }
}