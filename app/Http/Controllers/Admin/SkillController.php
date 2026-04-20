<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SkillCategory;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function index(): View
    {
        return view('admin.skills.index', [
            'skills' => Skill::query()->latest('published_at')->latest('id')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.skills.form', [
            'skill' => new Skill(),
            'categories' => collect(SkillCategory::cases())
                ->map(fn (SkillCategory $category): array => [
                    'value' => $category->value,
                    'label' => $category->label(),
                ])
                ->all(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Skill::query()->create($validated);

        return redirect()->route('admin.skills.index')->with('status', 'Skill created successfully.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.form', [
            'skill' => $skill,
            'categories' => collect(SkillCategory::cases())
                ->map(fn (SkillCategory $category): array => [
                    'value' => $category->value,
                    'label' => $category->label(),
                ])
                ->all(),
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $skill->update($validated);

        return redirect()->route('admin.skills.index')->with('status', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('status', 'Skill deleted successfully.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::enum(SkillCategory::class)],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'years' => ['required', 'integer', 'min:0', 'max:50'],
            'description' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}