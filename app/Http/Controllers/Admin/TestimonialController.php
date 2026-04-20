<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->orderByDesc('id')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', [
            'testimonial' => new Testimonial(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $this->nextSortOrder();

        Testimonial::query()->create($validated);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', [
            'testimonial' => $testimonial,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial deleted successfully.');
    }

    public function sort(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:testimonials,id'],
        ]);

        foreach ($validated['order'] as $index => $testimonialId) {
            Testimonial::query()->whereKey($testimonialId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'sorted']);
    }

    private function nextSortOrder(): int
    {
        return (int) (Testimonial::query()->max('sort_order') ?? 0) + 1;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(): array
    {
        return [
            'quote' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'url', 'max:2048'],
        ];
    }
}