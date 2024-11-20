<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\AddArtistRequest;
use App\Http\Requests\UpdateArtistRequest;

/**
 * @OA\Schema(
 *     schema="Artist",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", description="ID исполнителя"),
 *     @OA\Property(property="name", type="string", description="Имя исполнителя"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обновления")
 * )
 */


class ArtistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/artists",
     *     summary="Получить список всех исполнителей",
     *     description="Возвращает список всех исполнителей в базе данных",
     *     tags={"Artists"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ с данными исполнителей",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Artist")
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
        return Artist::with('albums')->get();
    }

     /**
     * @OA\Post(
     *     path="/api/artists",
     *     summary="Создать исполнителя",
     *     description="Создает исполнителя и возвращает его данные",
     *     tags={"Artists"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Имя исполнителя"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Исполнитель успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Artist")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function store(AddArtistRequest $request)
    {
        $data = $request->validated();
        $artist = Artist::create($data);

        return response()->json($artist, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/artists/{id}",
     *     summary="Обновить данные исполнителя",
     *     tags={"Artists"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID исполнителя",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Имя исполнителя")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Исполнитель обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Artist")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Исполнитель не найден"
     *     )
     * )
     */
    public function update(UpdateArtistRequest $request, $id)
    {
        $data = $request->validated();

        $artist = Artist::findOrFail($id);
        $artist->update($data);

        return response()->json($artist);
    }

    /**
     * @OA\Delete(
     *     path="/api/artists/{id}",
     *     summary="Удалить исполнителя",
     *     tags={"Artists"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID исполнителя",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Исполнитель удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Исполнитель не найден"
     *     )
     * )
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();

        return response()->json(null, 204);
    }
}
