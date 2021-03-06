<?php
/**
 * Tests for the DB\Table
 */
include dirname(__DIR__) . '/vendor/autoload.php';

use Objectiveweb\DB;
use Objectiveweb\DB\Table;

class TableTest extends PHPUnit_Framework_TestCase
{
    /** @var  Table */
    static protected $table;

    public static function setUpBeforeClass()
    {
        $db = DB::connect('mysql:dbname=objectiveweb;host=127.0.0.1', 'root', getenv('MYSQL_PASSWORD'));
        $db->query('drop table if exists db_test')->exec();

        $db->query('create table db_test
            (`id` INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255));')->exec();

        self::$table = $db->table('db_test');
    }

    public function testInsert()
    {
        $id = self::$table->post(array('name' => 'test'));

        $this->assertEquals(1, $id);

        $id = self::$table->post(array('name' => 'test1'));

        $this->assertEquals(2, $id);

        $id = self::$table->post(array('name' => 'test2'));

        $this->assertEquals(3, $id);

        $id = self::$table->post(array('name' => 'test3'));

        $this->assertEquals(4, $id);

        $id = self::$table->post(array('name' => null));

        $this->assertEquals(5, $id);

    }


    public function testSelectAll()
    {
        $rows = self::$table->select()->all();

        $this->assertEquals(5, count($rows));
        $this->assertEquals('test', $rows[0]['name']);
    }

	public function testGetRoot() 
	{
		$rows = self::$table->get();
		
        $this->assertEquals(5, count($rows['_embedded']['db_test']));
        $this->assertEquals('test', $rows['_embedded']['db_test'][0]['name']);
		
		$rows = self::$table->index();
		
        $this->assertEquals(5, count($rows['_embedded']['db_test']));
        $this->assertEquals('test', $rows['_embedded']['db_test'][0]['name']);
	}
	
	public function testPagination()
	{
		$rows = self::$table->index(array('size' => 2));
		
        $this->assertEquals(2, count($rows['_embedded']['db_test']));
        $this->assertEquals('test', $rows['_embedded']['db_test'][0]['name']);
		$this->assertEquals(2, $rows['page']['size']);
		$this->assertEquals(0, $rows['page']['number']);
		$this->assertEquals(3, $rows['page']['totalPages']);
		$this->assertEquals(5, $rows['page']['totalElements']);
		
		$rows = self::$table->index(array('size' => 2, 'page' => 1));
		
        $this->assertEquals(2, count($rows['_embedded']['db_test']));
        $this->assertEquals('test2', $rows['_embedded']['db_test'][0]['name']);
		$this->assertEquals(2, $rows['page']['size']);
		$this->assertEquals(1, $rows['page']['number']);
		$this->assertEquals(3, $rows['page']['totalPages']);
		$this->assertEquals(5, $rows['page']['totalElements']);
		
		$rows = self::$table->index(array('size' => 2, 'page' => 2));
		
        $this->assertEquals(1, count($rows['_embedded']['db_test']));
        $this->assertEquals(null, $rows['_embedded']['db_test'][0]['name']);
		$this->assertEquals(2, $rows['page']['size']);
		$this->assertEquals(2, $rows['page']['number']);
		$this->assertEquals(3, $rows['page']['totalPages']);
		$this->assertEquals(5, $rows['page']['totalElements']);
	}
	
    public function testUpdate()
    {
        $r = self::$table->put(array('name' => 'test1'), array('name' => 'test4'));

        $this->assertEquals(1, $r['updated']);
    }


    public function testSelectFetch()
    {
        $r = self::$table->select(array('name' => 'test4'))->all();
        $this->assertNotEmpty($r);
        $this->assertEquals('test4', $r[0]['name']);

    }

	public function testGetCollection() 
	{
        $r = self::$table->get(array('name' => 'test4'));
        $this->assertNotEmpty($r['_embedded']['db_test']);
        $this->assertEquals('test4', $r['_embedded']['db_test'][0]['name']);
        $this->assertNotEmpty($r['page']);
	}
	
    public function testSelectParams() {
        $r = self::$table->select(array('name' => 'test4'), array( 'fields' => array( 'id' )))->all();

        $this->assertNotEmpty($r);
		$keys = array_keys($r[0]);
        $this->assertEquals(1, count($keys));
        $this->assertEquals('id', $keys[0]);
    }

    public function testGetParams() {
        $r = self::$table->get(1, array( 'fields' => 'name' ));

        $this->assertNotEmpty($r);

        $this->assertEquals(1, count($r));
        $this->assertEquals('test', $r['name']);
    }

    public function testSelectEmptyResults()
    {
        $r = self::$table->select(array('name' => 'test5'))->all();

        $this->assertEmpty($r);

    }

    public function testUpdateKey() {
        $r = self::$table->put(3, array('name' => 'test2.1'));

        $this->assertEquals(1, $r['updated']);
    }

    public function testSelectKey() {
        $r = self::$table->get(3);

        $this->assertEquals('test2.1', $r['name']);
    }

    public function testSelectNull()
    {
        $r = self::$table->select(array('name' => null))->all();

        $this->assertEquals(1, count($r));
        $this->assertEquals(5, $r[0]['id']);
    }

    public function testDelete()
    {
        $rows = self::$table->select()->all();
        $this->assertEquals(count($rows), 5);

        $r = self::$table->delete(array('name' => 'test1'));
        $this->assertEquals(0, $r);

        $r = self::$table->delete(array('name' => 'test4'));
        $this->assertEquals(1, $r);

        $rows = self::$table->select()->all();
        $this->assertEquals(count($rows), 4);

    }


}