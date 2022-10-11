<?php

namespace ApiExample\Controllers;

use ApiExample\Exceptions\AppException;
use ApiExample\Models\User as UserModel;
use ApiExample\Registry;
use ApiExample\RegistryKeys;

class UserValidate
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel(Registry::get(RegistryKeys::DATABASE));
    }


    /**
     * @throws AppException
     */
    public function create(?array $add_info): array
    {
        $user_info = [];

        if (is_null($add_info)) {
            throw new AppException('No data were provided');
        }
        if (empty($add_info['telephone'])) {
            throw new AppException('Telephone is missing');
        }
        if (!is_integer($add_info['telephone'])) {
            throw new AppException('Telephone should be a number without other chars');
        }
        if ($this->model->getByPhone($add_info['telephone'])) {
            throw new AppException('Telephone number is already used');
        }
        $user_info['telephone'] = $add_info['telephone'];

        if (isset($add_info['email'])) {
            if (!filter_var($add_info['email'], FILTER_VALIDATE_EMAIL)) {
                throw new AppException('Email is invalid');
            }
            if ($this->model->getByEmail($add_info['email'])) {
                throw new AppException('Email is already used');
            }
        }
        $user_info['email'] = $add_info['email'] ?? null;

        if (isset($add_info['card_id'])) {
            if (!is_integer($add_info['card_id'])) {
                throw new AppException('Card ID should be a number without other chars');
            }
            if ($this->model->getByCardId($add_info['card_id'])) {
                throw new AppException('Card_id is already used');
            }
        }
        $user_info['card_id'] = $add_info['card_id'] ?? null;

        $user_info['name'] = $add_info['name'] ?? '';
        $user_info['notes'] = $add_info['notes'] ?? '';
        $user_info['balance'] = 0;

        return $user_info;
    }


    /**
     * @throws AppException
     */
    public function update(?array $add_info, array $user_info): array
    {
        if (is_null($add_info)) {
            throw new AppException('No data were provided');
        }

        $array_keys = array_keys($add_info);

        if (in_array('telephone', $array_keys, true)) {
            //can't be null, all users have telephone
            if (!is_integer($add_info['telephone'])) {
                throw new AppException('Telephone should be a number without other chars');
            }
            if ($this->model->getByPhone($add_info['telephone'])) {
                throw new AppException('Telephone number is already used');
            }
            $user_info['telephone'] = $add_info['telephone'];
        }

        if (in_array('email', $array_keys, true)) {
            if (!is_null($add_info['email']) && !filter_var($add_info['email'], FILTER_VALIDATE_EMAIL)) {
                throw new AppException('Email is invalid');
            }
            if (!is_null($add_info['email']) && $this->model->getByEmail($add_info['email'])) {
                throw new AppException('Email is already used');
            }
            $user_info['email'] = $add_info['email'] ?? null;
        }

        if (in_array('card_id', $array_keys, true)) {
            if (!is_null($add_info['card_id']) && !is_integer($add_info['card_id'])) {
                throw new AppException('Card ID should be a number without other chars');
            }
            if (!is_null($add_info['card_id']) && $this->model->getByCardId($add_info['card_id'])) {
                throw new AppException('Card_id is already used');
            }
            $user_info['card_id'] = $add_info['card_id'] ?? null;
        }

        if (in_array('name', $array_keys, true)) {
            $user_info['name'] = $add_info['name'] ?? '';
        }

        if (in_array('notes', $array_keys, true)) {
            $user_info['notes'] = $add_info['notes'] ?? '';
        }

        return $user_info;
    }

}