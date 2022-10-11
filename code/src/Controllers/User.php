<?php
declare(strict_types=1);

namespace ApiExample\Controllers;

use ApiExample\Exceptions\AppException;
use ApiExample\Models\User as UserModel;
use ApiExample\Registry;
use ApiExample\RegistryKeys;

class User
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel(Registry::get(RegistryKeys::DATABASE));
    }

    public function addFake(): void
    {
        for ($i = 1; $i < 100; $i++) {
            $this->model->create($this->getFakeUser());
        }
    }

    /**
     * @throws AppException
     */
    public function create(): void
    {
        $request = Registry::get(RegistryKeys::REQUEST);
        $json = $request->getRawPost();
        $user_info = (new UserValidate())->create(json_decode($json, true));
        $user_id = $this->model->create($user_info);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'OK', 'user_id' => $user_id], JSON_PRETTY_PRINT);
    }


    /**
     * @throws AppException
     */
    public function update(string $user_id): void
    {
        $user_info = $this->model->getById(intval($user_id));
        if (!$user_info) {
            throw new AppException('No user');
        }

        $request = Registry::get(RegistryKeys::REQUEST);
        $json = $request->getRawPost();
        $user_info = (new UserValidate())->update(json_decode($json, true), $user_info);
        $this->model->update($user_info);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'OK', 'msg' => 'User info updated'], JSON_PRETTY_PRINT);
    }

    /**
     * @throws AppException
     */
    public function find($user_id)
    {
        $user_info = $this->model->getById(intval($user_id));
        if (!$user_info) {
            throw new AppException('No user');
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'OK', 'user_info' => $user_info], JSON_PRETTY_PRINT);
    }

    public function getAll(): void
    {
        $users = $this->model->getAll();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($users, JSON_PRETTY_PRINT);
    }

    public function delete($user_id): void
    {
        $rows = $this->model->delete(intval($user_id));
        if ($rows === 0) {
            throw new AppException('No user');
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'OK', 'msg' => 'User has been removed'], JSON_PRETTY_PRINT);
    }


    private function getFakeUser(): array
    {
        $faker = \Faker\Factory::create();

        $data['email'] = $faker->email();
        $data['telephone'] = rand(490000000000, 499000000000);
        $data['name'] = $faker->name();
        $data['card_id'] = null;
        $data['notes'] = $faker->sentence();
        $data['balance'] = '0';

        return $data;
    }


}