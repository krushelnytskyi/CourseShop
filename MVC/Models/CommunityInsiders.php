<?php


namespace MVC\Models;

use \System\ORM\Model;

/**
 * Class CommunityInsiders
 * @package MVC\Models
 * @table(community_insiders)
 * @updateBy(id,user)
 * In this table save only users with custom permissions!
 */
class CommunityInsiders extends Model
{
    const PERMISSION_LEVEL_TRUSTWORTHY = 1; //can attach articles to community without moderating
    const PERMISSION_LEVEL_MODERATOR   = 2; //can attach or detach article from community

    /**
     * Key for community
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\Community)
     * @foreignField(id)
     * @var Community
     */
    private $id;

    /**
     * Key for user, they aren't regular subscribers,
     * in this table save only users with custom permissions
     *
     * @columnType(INT(11) UNSIGNED NOT NULL)
     * @foreignModel(MVC\Models\User)
     * @foreignField(id)
     * @var User
     */
    private $user;

    /**
     * permission level
     *
     * @columnName(permission_level)
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var int
     */
    private $permissionLevel;

    /**
     * @return Community
     */
    public function getId(): Community
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getPermissionLevel(): int
    {
        return $this->permissionLevel;
    }

    /**
     * @param Community|int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setNew(true);
        $this->id = $id;
        return $this;
    }

    /**
     * @param User|int $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->setNew(true);
        $this->user = $user;
        return $this;
    }

    /**
     * @param int $permissionLevel
     * @return $this
     */
    public function setPermissionLevel(int $permissionLevel)
    {
        $this->permissionLevel = $permissionLevel;
        return $this;
    }



}