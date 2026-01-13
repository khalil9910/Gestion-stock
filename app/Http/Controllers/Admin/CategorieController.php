<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CategorieController extends Controller
{
    public function index(): View
    {
        $categories = Categorie::query()->orderBy('nom')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('categories', 'public');
        }

        Categorie::create($data);

        return redirect()->route('admin.categories.index');
    }

    public function show(Categorie $category): View
    {
        return view('admin.categories.show', ['category' => $category]);
    }

    public function archive(): View
    {
        $categories = Categorie::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('admin.categories.archive', compact('categories'));
    }

    public function restore(int $id): RedirectResponse
    {
        $category = Categorie::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.archive');
    }

    public function edit(Categorie $category): View
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Categorie $category): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('categories', 'public');

            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }

            $data['image_path'] = $newPath;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Categorie $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
