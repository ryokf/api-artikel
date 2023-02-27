<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\helpers\ResponseFormatter;
use App\Http\Resources\ArticleDetailResource;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

// use ResponseFormatter;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');
        $category = $request->input('category');

        if ($id) {
            $articles = Article::with('category:id,name')
                ->with('writer:id,name')
                ->where('id', $id)
                ->first();

            if ($articles) {
                $data = new ArticleDetailResource($articles);
                return ResponseFormatter::success($data, 'data berhasil diambil', 200);
            } else {
                return ResponseFormatter::error(null, 'data tidak ditemukan', 404);
            }
        }

        $articles = Article::with('category:id,name');

        if ($title) {
            $articles->where('title', 'like', '%' . $title . '%');
        }
        if ($content) {
            $articles->where('title', 'like', '%' . $content . '%');
        }
        if ($category) {
            $articles->where('category_id', $category);
        }

        $data = $articles->get();

        if (count($data) != 0) {
            return ResponseFormatter::success(ArticleResource::collection($data));
        } else {
            return ResponseFormatter::error('article tidak ditemukan');
        }
    }
}
