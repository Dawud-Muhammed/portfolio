<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SkillCategory;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::query()
            ->orderByRaw('FIELD(category, ?, ?, ?, ?)', [
                SkillCategory::Backend->value,
                SkillCategory::Frontend->value,
                SkillCategory::Data->value,
                SkillCategory::Tooling->value,
            ])
            ->orderByDesc('level')
            ->orderBy('name')
            ->get();

        return view('admin.skills.index', [
            'skillCategories' => collect(SkillCategory::cases())->map(fn (SkillCategory $category): array => [
                'value' => $category->value,
                'label' => $category->label(),
            ])->all(),
            'skillGroups' => collect(SkillCategory::cases())->map(function (SkillCategory $category) use ($skills): array {
                return [
                    'category' => $category,
                    'skills' => $skills
                        ->filter(fn (Skill $skill): bool => ($skill->category?->value ?? $skill->category) === $category->value)
                        ->values(),
                ];
            })->all(),
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
        $request->merge([
            'skill_id' => $this->resolveSkillId(
                (string) $request->input('skill_id', ''),
                (string) $request->input('name', '')
            ),
        ]);

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
        $request->merge([
            'skill_id' => $this->resolveSkillId(
                (string) $request->input('skill_id', ''),
                (string) $request->input('name', ''),
                $skill
            ),
        ]);

        $validated = $request->validate($this->rules($skill));

        $skill->update($validated);

        return redirect()->route('admin.skills.index')->with('status', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('status', 'Skill deleted successfully.');
    }

    public function toggle(Request $request, Skill $skill): JsonResponse
    {
        $skill->update([
            'is_published' => ! $skill->is_published,
        ]);

        return response()->json([
            'message' => 'Skill publication status updated.',
            'is_published' => $skill->is_published,
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?Skill $skill = null): array
    {
        $skillIdRules = ['nullable', 'string', 'max:255'];

        if ($skill !== null) {
            $skillIdRules[] = Rule::unique('skills', 'skill_id')->ignore($skill);
        } else {
            $skillIdRules[] = Rule::unique('skills', 'skill_id');
        }

        return [
            'skill_id' => $skillIdRules,
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::enum(SkillCategory::class)],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'years' => ['required', 'integer', 'min:0', 'max:50'],
            'description' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    private function resolveSkillId(string $skillId, string $name, ?Skill $ignoreSkill = null): string
    {
        $base = Str::slug(trim($skillId !== '' ? $skillId : $name));

        if ($base === '') {
            return '';
        }

        $candidate = $base;
        $suffix = 2;

        while (Skill::query()
            ->where('skill_id', $candidate)
            ->when($ignoreSkill !== null, fn ($query) => $query->whereKeyNot($ignoreSkill->getKey()))
            ->exists()) {
            $candidate = $base.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }
}