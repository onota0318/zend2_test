<?php
/**
 * Sampleモジュール用memberテーブルFixtureレコード
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Fixture;

use Onota0318\Zend2Adapter\Test\AbstractFixtureRecord;

class IndexMemberFixtureRecord extends AbstractFixtureRecord
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
        return array(
            array(
                "id"              => "1",
                "last_login_date" => "2015-01-02 12:23:34",
                "created_date"    => "2015-01-02 12:23:34",
                "modified_date"   => "2015-01-02 12:23:34",
                "deleted_date"    => null,
            ),
            array(
                "id"              => "2",
                "last_login_date" => "2015-01-02 12:23:34",
                "created_date"    => "2015-01-02 12:23:34",
                "modified_date"   => "2015-01-02 12:23:34",
                "deleted_date"    => null,
            ),        
            array(
                "id"              => "3",
                "last_login_date" => "2015-01-02 12:23:34",
                "created_date"    => "2015-01-02 12:23:34",
                "modified_date"   => "2015-01-02 12:23:34",
                "deleted_date"    => null,
            ),               
        );
    }
}
