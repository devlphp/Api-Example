<?php

namespace ApiExample\Models;

use PDO;

class User
{
    public function __construct(private PDO $db)
    {

    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO users (email, telephone, name, card_id, notes, balance)
                VALUES (:email, :telephone, :name, :card_id, :notes, :balance)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":email", $data["email"]);
        $stmt->bindValue(":telephone", $data["telephone"], PDO::PARAM_INT);
        $stmt->bindValue(":name", $data["name"]);
        $stmt->bindValue(":card_id", $data["card_id"], PDO::PARAM_INT);
        $stmt->bindValue(":notes", $data["notes"]);
        $stmt->bindValue(":balance", $data["balance"]);
        $stmt->execute();

        return $this->db->lastInsertId();
    }


    public function update(array $data): void
    {
        $sql = 'UPDATE users SET email = :email, telephone = :telephone, name = :name, card_id = :card_id, notes = :notes, balance = :balance WHERE id = :id';

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":email", $data["email"]);
        $stmt->bindValue(":telephone", $data["telephone"], PDO::PARAM_INT);
        $stmt->bindValue(":name", $data["name"]);
        $stmt->bindValue(":card_id", $data["card_id"], PDO::PARAM_INT);
        $stmt->bindValue(":notes", $data["notes"]);
        $stmt->bindValue(":balance", $data["balance"]);
        $stmt->bindValue(":id", $data["id"]);
        $stmt->execute();

    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM users';
        $stmt = $this->db->query($sql);
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getById(int $id): mixed
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPhone(int $telephone): mixed
    {
        $sql = 'SELECT * FROM users WHERE telephone = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$telephone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByCardId(int $card_id)
    {
        $sql = 'SELECT * FROM users WHERE card_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$card_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail(string $email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): int
    {
        $sql = 'DELETE FROM users WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}