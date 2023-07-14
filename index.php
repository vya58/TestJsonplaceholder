<?php

require_once 'vendor/autoload.php';

use App\Src\Repository\JsonPlaceholderRepository;

// Получение всех пользователей
$users = JsonPlaceholderRepository::getUsers();

/*
echo '<pre>';
var_dump($users);
echo '</pre>';
*/

// Получение конкретного пользователя по id
$userId = 9;

$user = JsonPlaceholderRepository::getUser($userId);

/*
echo '<pre>';
var_dump($user);
echo '</pre>';
*/

// Получение всех постов пользователя
$posts = JsonPlaceholderRepository::getPosts($userId);

/*
echo '<pre>';
var_dump($posts);
echo '</pre>';
*/

// Получение всех задач пользователя
$todos = JsonPlaceholderRepository::getTodos($userId);

/*
echo '<pre>';
var_dump($todos);
echo '</pre>';
*/

// Создание поста
$title = 'Заголовок поста';
$body = 'Текст поста';

$newPost = JsonPlaceholderRepository::createPost($userId, $title, $body);

/*
echo '<pre>';
var_dump($newPost);
echo '</pre>';
*/

// Редактирование поста
$post = JsonPlaceholderRepository::getPost(50);

$postId = $post->id;
$authorId = $post->userId;

$updatePostData = [];

$updatePost = JsonPlaceholderRepository::updatePost($postId, $authorId, $updatePostData);

/*
echo '<pre>';
var_dump($updatePost);
echo '</pre>';
*/

$updatePostData = [
    'body' => 'Новый текст поста'
];

$updatePost = JsonPlaceholderRepository::updatePost($postId, $authorId, $updatePostData);

/*
echo '<pre>';
var_dump($updatePost);
echo '</pre>';
*/

$updatePostData['title'] = 'Новый заголовок поста';

$updatePost = JsonPlaceholderRepository::updatePost($postId, $authorId, $updatePostData);

/*
echo '<pre>';
var_dump($updatePost);
echo '</pre>';
*/
$authorId += $authorId;

$updatePost = JsonPlaceholderRepository::updatePost($postId, $authorId, $updatePostData);

/*
echo '<pre>';
var_dump($updatePost);
echo '</pre>';
*/

// Удаление поста
// ...если, не автор поста
$delete = JsonPlaceholderRepository::deletePost($postId, $authorId);

/*
echo '<pre>';
var_dump($delete);
echo '</pre>';
*/

// ...если, автор поста
$authorId = $post->userId;

$delete = JsonPlaceholderRepository::deletePost($postId, $authorId);
