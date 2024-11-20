<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Http\Requests\AddAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Album",
 *     type="object",
 *     required={"title", "artist_id", "release_year"},
 *     @OA\Property(property="id", type="integer", description="ID альбома", example=1),
 *     @OA\Property(property="title", type="string", description="Название альбома", example="Abbey Road"),
 *     @OA\Property(property="artist_id", type="integer", description="ID исполнителя", example=1),
 *     @OA\Property(property="release_year", type="integer", description="Год выпуска альбома", example=1969),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания записи", example="2024-11-01T14:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления записи", example="2024-11-01T14:30:00Z")
 * )
 */

class AlbumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/albums",
     *     summary="Получить список всех альбомов",
     *     description="Возвращает список всех альбомов в базе данных",
     *     tags={"Albums"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ с данными альбомов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Album")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function index()
    {
        $albums = Album::all();
        return response()->json($albums);
    }


    /**
     * @OA\Get(
     *     path="/api/albums/{id}",
     *     summary="Получить альбом по ID",
     *     description="Возвращает информацию об альбоме по его ID",
     *     tags={"Albums"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID альбома",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о найденном альбоме",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Альбом не найден"
     *     )
     * )
     */
    public function show($id)
    {
        return Album::with('artist')->findOrFail($id);
    }

    /**
     * @OA\Post(
     *     path="/api/albums",
     *     summary="Создать новый альбом",
     *     description="Создает новый альбом и возвращает его данные",
     *     tags={"Albums"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "artist_id", "release_year"},
     *             @OA\Property(property="title", type="string", description="Название альбома"),
     *             @OA\Property(property="artist_id", type="integer", description="ID исполнителя"),
     *             @OA\Property(property="release_year", type="integer", description="Год выпуска альбома")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Альбом успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function store(AddAlbumRequest $request)
    {
        $album = Album::create($request->validated());
        return response()->json($album, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/albums/{id}",
     *     summary="Обновить данные альбома",
     *     description="Обновляет данные альбома по его ID",
     *     tags={"Albums"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID альбома",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "artist_id", "release_year"},
     *             @OA\Property(property="title", type="string", description="Название альбома"),
     *             @OA\Property(property="artist_id", type="integer", description="ID исполнителя"),
     *             @OA\Property(property="release_year", type="integer", description="Год выпуска альбома")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Альбом успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Альбом не найден"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function update(UpdateAlbumRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->validated());
        return response()->json($album);
    }

    /**
     * @OA\Delete(
     *     path="/api/albums/{id}",
     *     summary="Удалить альбом",
     *     description="Удаляет альбом по его ID",
     *     tags={"Albums"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID альбома",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Альбом успешно удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Альбом не найден"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return response()->json(null, 204);
    }
}
