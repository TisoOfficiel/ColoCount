<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

final class User extends BaseEntity
{
    private int $user_id;
    private string $username;
    private string $email;
    private string $password;
    private string $created_at;
    private string $updated_at;
    private string $deleted_at;

    /**
     * @return int
     */
    public function getUser_Id(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $id
     */
    public function setUser_Id(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $userName
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getCreated_At(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return User
     */
    public function setCreated_At(string $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated_At(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return User
     */
    public function setUpdated_At(string $updated_at): User
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeleted_At(): string
    {
        return $this->deleted_at;
    }

    /**
     * @param string $deleted_at
     * @return User
     */
    public function setDeleted_At(string $deleted_at): User
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }


}

