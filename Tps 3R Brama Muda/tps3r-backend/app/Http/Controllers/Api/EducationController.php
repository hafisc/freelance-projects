<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    /**
     * Display a listing of educations.
     * Format response sesuai dengan Flutter EdukasiModel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);
            $status = $request->input('status');

            $query = Education::with('author')
                ->orderBy('created_at', 'desc');

            // Filter by status if provided
            if ($status && in_array($status, Education::statuses())) {
                $query->where('status', $status);
            }

            // For non-authenticated users, only show published
            if (!$request->user()) {
                $query->published();
            }

            $educations = $query->paginate($perPage);

            // Transform data sesuai format Flutter
            $data = $educations->map(function ($education) {
                return [
                    'id' => $education->id,
                    'title' => $education->title,
                    'slug' => $education->slug,
                    'thumbnail' => $education->thumbnail,
                    'content' => $education->content,
                    'author_id' => $education->author_id,
                    'author_name' => $education->author?->name ?? 'Admin',
                    'status' => $education->status,
                    'created_at' => $education->created_at,
                    'updated_at' => $education->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data edukasi berhasil diambil',
                'data' => $data,
                'current_page' => $educations->currentPage(),
                'last_page' => $educations->lastPage(),
                'total' => $educations->total(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data edukasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created education.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'nullable|in:draft,published',
            ]);

            $validated['author_id'] = $request->user()->id;
            $validated['status'] = $validated['status'] ?? Education::STATUS_DRAFT;

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = 'educations/' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('', $filename, 'public');
                $validated['thumbnail'] = $filename;
            }

            $education = Education::create($validated);
            $education->load('author');

            return response()->json([
                'success' => true,
                'message' => 'Edukasi berhasil dibuat',
                'data' => [
                    [
                        'id' => $education->id,
                        'title' => $education->title,
                        'slug' => $education->slug,
                        'thumbnail' => $education->thumbnail,
                        'content' => $education->content,
                        'author_id' => $education->author_id,
                        'author_name' => $education->author?->name ?? 'Admin',
                        'status' => $education->status,
                        'created_at' => $education->created_at,
                        'updated_at' => $education->updated_at,
                    ]
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat edukasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified education.
     *
     * @param Request $request
     * @param Education $education
     * @return JsonResponse
     */
    public function show(Request $request, Education $education): JsonResponse
    {
        try {
            // For non-authenticated users, only show published
            if (!$request->user() && !$education->isPublished()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Edukasi tidak ditemukan',
                ], 404);
            }

            $education->load('author');

            return response()->json([
                'success' => true,
                'message' => 'Edukasi berhasil dimuat',
                'data' => [
                    [
                        'id' => $education->id,
                        'title' => $education->title,
                        'slug' => $education->slug,
                        'thumbnail' => $education->thumbnail,
                        'content' => $education->content,
                        'author_id' => $education->author_id,
                        'author_name' => $education->author?->name ?? 'Admin',
                        'status' => $education->status,
                        'created_at' => $education->created_at,
                        'updated_at' => $education->updated_at,
                    ]
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat edukasi',
            ], 500);
        }
    }

    /**
     * Update the specified education.
     *
     * @param Request $request
     * @param Education $education
     * @return JsonResponse
     */
    public function update(Request $request, Education $education): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'nullable|in:draft,published',
            ]);

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($education->thumbnail && Storage::disk('public')->exists($education->thumbnail)) {
                    Storage::disk('public')->delete($education->thumbnail);
                }

                $file = $request->file('thumbnail');
                $filename = 'educations/' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('', $filename, 'public');
                $validated['thumbnail'] = $filename;
            }

            $education->update($validated);
            $education->load('author');

            return response()->json([
                'success' => true,
                'message' => 'Edukasi berhasil diperbarui',
                'data' => [
                    [
                        'id' => $education->id,
                        'title' => $education->title,
                        'slug' => $education->slug,
                        'thumbnail' => $education->thumbnail,
                        'content' => $education->content,
                        'author_id' => $education->author_id,
                        'author_name' => $education->author?->name ?? 'Admin',
                        'status' => $education->status,
                        'created_at' => $education->created_at,
                        'updated_at' => $education->updated_at,
                    ]
                ],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui edukasi',
            ], 500);
        }
    }

    /**
     * Remove the specified education.
     *
     * @param Request $request
     * @param Education $education
     * @return JsonResponse
     */
    public function destroy(Request $request, Education $education): JsonResponse
    {
        try {
            // Only admin can delete
            if (!$request->user() || !$request->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus edukasi ini',
                ], 403);
            }

            // Delete thumbnail
            if ($education->thumbnail && Storage::disk('public')->exists($education->thumbnail)) {
                Storage::disk('public')->delete($education->thumbnail);
            }

            $education->delete();

            return response()->json([
                'success' => true,
                'message' => 'Edukasi berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus edukasi',
            ], 500);
        }
    }
}
