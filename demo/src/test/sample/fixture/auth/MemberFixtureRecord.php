<?php
/**
 * memberテーブルFixtureレコード
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Fixture\Auth;

use Onota0318\Zend2Adapter\Test\AbstractFixtureRecord;
use Onota0318\Library\DateTimer;
use Onota0318\Library\StringConverter;

class MemberFixtureRecord extends AbstractFixtureRecord
{
    /**
     * @var string テーブル名 
     */
    protected $tableName = "member";
    
    /**
     * {@inheriteDocs}
     */
    protected function records()
    {
        $current = DateTimer::getSystemDateTime("Y-m-d H:i:s");

        return array(
            array(
                "id"              => "1",
                "login_id"        => "hogeID",
                "password"        => StringConverter::hash("hogePW"),
                "first_name"      => "尾野",
                "last_name"       => "テスト",
                "gender"          => "1",
                "pref"            => "13",
                "last_login_date" => $current,
                "created_date"    => $current,
                "modified_date"   => $current,
                "deleted_date"    => null,
            ),
        );
    }
}
