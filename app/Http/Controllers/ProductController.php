<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Public storefront
    public function index(Request $request)
    {
        $categories = config('catalog.categories');
        $activeCat = $request->query('cat', $categories[0]['id']);
        $activeSub = $request->query('sub');

        $query = Product::where('category', $activeCat);
        if ($activeSub) {
            $query->where('subcategory', $activeSub);
        }

        return view('storefront.index', [
            'categories' => $categories,
            'activeCat' => $activeCat,
            'activeSub' => $activeSub,
            'items' => $query->get(),
        ]);
    }

    // Admin: list + form
    public function adminIndex(Request $request)
    {
        return view('admin.index', [
            'categories' => config('catalog.categories'),
            'products' => Product::orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
            'editing' => $request->query('edit') ? Product::find($request->query('edit')) : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = array_merge($data, $this->handleUploads($request));

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Item saved.');
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $this->validated($request);
        $data = array_merge($data, $this->handleUploads($request, $product));
        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Item saved.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('cloudinary')->delete($product->image_path);
        }
        if ($product->video_path) {
            Storage::disk('cloudinary')->delete($product->video_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Item deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'subcategory' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:10240',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:102400',
        ], [
            'image.max' => 'The image must not be larger than 10MB.',
            'image.mimes' => 'The image must be a JPG, PNG, WEBP, or GIF file.',
            'video.max' => 'The video must not be larger than 100MB.',
            'video.mimetypes' => 'The video must be an MP4, WEBM, or MOV file.',
        ]);

        // image/video are handled separately in handleUploads(), not stored directly
        unset($data['image'], $data['video']);

        $cat = collect(config('catalog.categories'))->firstWhere('id', $data['category']);
        if (empty($cat['subcategories'])) {
            $data['subcategory'] = null;
        }

        return $data;
    }

   private function handleUploads(Request $request, ?Product $existing = null): array
    {
        $result = [
            'image_path' => $existing->image_path ?? null,
            'image_url' => $existing->image_url ?? null,
            'video_path' => $existing->video_path ?? null,
            'video_url' => $existing->video_url ?? null,
        ];

        if ($request->hasFile('image')) {
            // Delete the old image from Cloudinary before storing the new one
            if ($existing && $existing->image_path) {
                Storage::disk('cloudinary')->delete($existing->image_path);
            }

            $path = $request->file('image')->store('am_printing/images', 'cloudinary');
            $result['image_path'] = $path;
            $result['image_url'] = Storage::disk('cloudinary')->url($path);
        }

        if ($request->hasFile('video')) {
            // Delete the old video from Cloudinary before storing the new one
            if ($existing && $existing->video_path) {
                Storage::disk('cloudinary')->delete($existing->video_path);
            }

            $path = $request->file('video')->store('am_printing/videos', 'cloudinary');
            $result['video_path'] = $path;
            $result['video_url'] = Storage::disk('cloudinary')->url($path);
        }

        return $result;
    }
}