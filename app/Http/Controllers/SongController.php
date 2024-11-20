<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Http\Requests\AddSongToAlbumRequest;

/**
 * @OA\Schema(
 *     schema="Song",
 *     type="object",
 *     required={"title", "artist_id", "album_id", "release_date"},
 *     @OA\Property(property="id", type="integer", description="ID песни", example=1),
 *     @OA\Property(property="title", type="string", description="Название песни", example="Hey Jude"),
 *     @OA\Property(property="artist_id", type="integer", description="ID исполнителя", example=1),
 *     @OA\Property(property="album_id", type="integer", description="ID альбома", example=1),
 *     @OA\Property(property="release_date", type="string", format="date", description="Дата выпуска", example="1968-08-26"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания записи", example="2024-11-01T14:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления записи", example="2024-11-01T14:30:00Z")
 * )
 */
class SongController extends Controller
{
    /**
     * Получить список всех песен
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
     * @OA\Get(
     *     path="/api/songs",
     *     summary="Получить список всех песен",
     *     description="Возвращает список всех песен в базе данных",
     *     tags={"Songs"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ с данными песен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Song")
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
        return response()->json(Song::with('albums')->get());
    }

    /**
     * Создать новую песню
     *
     * @param CreateSongRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/api/songs",
     *     summary="Создать новую песню",
     *     description="Создает новую песню в базе данных",
     *     tags={"Songs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Создана новая песня",
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Некорректные данные"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function store(CreateSongRequest $request)
    {
        $data = $request->validated();

        $song = Song::create($data);

        return response()->json($song, 201);
    }

    /**
     * Показать информацию о песне по ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/api/songs/{id}",
     *     summary="Получить информацию о песне",
     *     description="Возвращает информацию о песне по ее ID",
     *     tags={"Songs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID песни",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ с данными песни",
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Песня не найдена"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Song::with('albums')->findOrFail($id));
    }

    /**
     * Обновить информацию о песне
     *
     * @param UpdateSongRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Put(
     *     path="/api/songs/{id}",
     *     summary="Обновить информацию о песне",
     *     description="Обновляет информацию о песне по ее ID",
     *     tags={"Songs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID песни",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о песне обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Песня не найдена"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function update(UpdateSongRequest $request, $id)
    {
        $data = $request->validated();

        $song = Song::findOrFail($id);
        $song->update($data);

        return response()->json($song);
    }

    /**
     * Удалить песню
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Delete(
     *     path="/api/songs/{id}",
     *     summary="Удалить песню",
     *     description="Удаляет песню по ее ID",
     *     tags={"Songs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID песни",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Песня удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Песня не найдена"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return response()->json(null, 204);
    }

    /**
     * Добавить песню в альбом
     *
     * @param AddSongToAlbumRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/api/songs/{id}/add-to-album",
     *     summary="Добавить песню в альбом",
     *     description="Добавляет песню в альбом по ID",
     *     tags={"Songs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID песни",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="album_id", type="integer", description="ID альбома", example=1),
     *             @OA\Property(property="track_number", type="integer", description="Номер трека в альбоме", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Песня добавлена в альбом",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Song added to album successfully."),
     *             @OA\Property(property="album", ref="#/components/schemas/Album")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Альбом или песня не найдены"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function addToAlbum(AddSongToAlbumRequest $request, $id)
    {
        $data = $request->validated();

        $song = Song::findOrFail($id);
        $album = Album::findOrFail($data['album_id']);

        $song->albums()->attach($album->id, ['track_number' => $data['track_number']]);

        return response()->json([
            'message' => 'Song added to album successfully.',
            'album' => $album
        ]);
    }
}
