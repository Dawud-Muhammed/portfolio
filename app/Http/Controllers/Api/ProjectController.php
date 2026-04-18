<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => [], 'message' => 'List of projects']);
    }

    public function store(): JsonResponse
    {
        return response()->json(['message' => 'Project created'], 201);
    }

    public function show(string $project): JsonResponse
    {
        return response()->json(['data' => ['id' => $project], 'message' => 'Project details']);
    }

    public function update(string $project): JsonResponse
    {
        return response()->json(['data' => ['id' => $project], 'message' => 'Project updated']);
    }

    public function destroy(string $project): JsonResponse
    {
        return response()->json(['message' => 'Project deleted']);
    }
}
