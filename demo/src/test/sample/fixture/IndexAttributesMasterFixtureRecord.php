<?php
/**
 * Sampleモジュール用attributes_masterテーブルFixtureレコード
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Fixture;

use Onota0318\Zend2Adapter\Test\AbstractFixtureRecord;

class IndexAttributesMasterFixtureRecord extends AbstractFixtureRecord
{
    /**
     * @var string テーブル名 
     */
    protected $tableName = "attributes_master";
    
    /**
     * {@inheriteDocs}
     */
    protected function records()
    {
        return array(
            array(
                "key"           => "key1",
                "detail"        => "ディテイル",
                "is_nullable"   => 0,
                "is_secret"     => 0,
                "created_date"  => "0000-00-00 00:00:00",
                "modified_date" => "0000-00-00 00:00:00",
                "deleted_date"  => "0000-00-00 00:00:00",
            ),
        );
    }
}
