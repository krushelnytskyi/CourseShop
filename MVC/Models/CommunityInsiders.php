<?php


namespace MVC\Models;

/**
 * Class CommunityInsiders
 * @package MVC\Models
 * @table(communityInsiders)
 * In this table save only users with custom permissions!
 */
class CommunityInsiders
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
     * @columnType(TINYINT(1) UNSIGNED NOT NULL)
     * @var int
     */
    private $permissionLevel;


}