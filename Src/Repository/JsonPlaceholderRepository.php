<?php

namespace App\Src\Repository;

use GuzzleHttp\Client;
use App\Src\Exceptions\ErrorException;

class JsonPlaceholderRepository
{
    private const JSONPLACEHOLDER_URI = 'http://jsonplaceholder.typicode.com/';

    /**
     * Метод получения всех пользователей
     * 
     * @return array
     */
    public static function getUsers(): array
    {
        $client = new Client();

        $response = $client->get(self::JSONPLACEHOLDER_URI . 'users');

        return json_decode($response->getBody());
    }

    /**
     * Метод получения пользователя по его id
     * 
     * @param  int $id - id пользователя
     * 
     * @return object
     */
    public static function getUser(int $id): object
    {
        $client = new Client();

        $response = $client->get(self::JSONPLACEHOLDER_URI . 'users/' . $id);
        return json_decode($response->getBody());
    }

    /**
     * Метод получения всех постов конкретного пользователя
     * 
     * @param  int $id - id пользователя
     * 
     * @return array
     */
    public static function getPosts(int $id): array
    {
        $client = new Client();

        $response = $client->get(self::JSONPLACEHOLDER_URI . 'users/' . $id . '/posts');

        return json_decode($response->getBody());
    }

    /**
     * Метод получения конкретного поста
     * 
     * @param  int $id - id поста
     * 
     * @return object

     */
    public static function getPost(int $id): object
    {
        $client = new Client();

        $response = $client->get(self::JSONPLACEHOLDER_URI . 'posts/' . $id);

        return json_decode($response->getBody());
    }

    /**
     * Метод получения всех заданий конкретного пользователя
     * 
     * @param  int $id - id пользователя
     * 
     * @return array
     */
    public static function getTodos(int $id): array
    {
        $client = new Client();

        $response = $client->get(self::JSONPLACEHOLDER_URI . 'users/' . $id . '/todos');

        return json_decode($response->getBody());
    }

    /**
     * Метод создания поста
     * 
     * правильнее передавать параметром объект класса Post, но не стал создавать, чтобы не выходить за рамки задания
     * 
     * @param  int $id - id пользователя
     * @param  string $title - заголовок поста
     * @param  string $body - 'тело' поста
     * 
     * @return ErrorException|object
     */
    public static function createPost(int $id, string $title, string $body): object
    {
        $client = new Client();

        if (!$title) {
            return new ErrorException(403, 'Отсутствует заголовок поста');
        }

        if (!$body) {
            return new ErrorException(403, 'Отсутствует текст поста');
        }

        $query = [
            'title' => $title,
            'body' => $body,
            'userId' => $id,
        ];

        $response = $client->post(self::JSONPLACEHOLDER_URI . 'users/' . $id . '/posts', ['json' => $query]);

        return json_decode($response->getBody());
    }

    /**
     * Метод редактирования поста
     * 
     * @param  int $id - id поста
     * @param  int $userId - id пользователя
     * @param  string $title - заголовок поста
     * @param  string $body - 'тело' поста
     * 
     * @return ErrorException|object
     */
    public static function updatePost(int $id, int $userId, array $updatePostData): object
    {
        $post = self::getPost($id);

        if ($userId !== $post->userId) {
            return new ErrorException(403, 'Редактировать можно только свой пост');
        }

        $client = new Client();

        $method = 'PUT';

        $query = [
            'id' => $id,
            'userId' => $userId,
        ];

        if (!isset($updatePostData['title']) && !isset($updatePostData['body'])) {
            return new ErrorException(403, 'Нет данных для изменения');
        }

        if (isset($updatePostData['title'])) {
            $query['title'] = $updatePostData['title'];
        }

        if (isset($updatePostData['body'])) {
            $query['body'] = $updatePostData['body'];
        }

        if (!isset($updatePostData['title']) || !isset($updatePostData['body'])) {
            $method = 'PATCH';
        }

        $response = $client->request($method, self::JSONPLACEHOLDER_URI . 'posts/' . $id, ['json' => $query]);

        return json_decode($response->getBody());
    }

    /**
     * Метод удаления поста
     * 
     * @param  int $id - id поста
     * @param  int $userId - id пользователя
     * 
     * @return ErrorException|void
     */
    public static function deletePost(int $id, int $userId)
    {
        $post = self::getPost($id);

        if ($userId !== $post->userId) {
            return new ErrorException(403, 'Удалить можно только свой пост');
        }

        $client = new Client();

        $client->delete(self::JSONPLACEHOLDER_URI . 'posts/' . $id);
    }
}
