<?php

namespace Gt\Input\InputData\Test;

use Gt\Input\InputData\InputData;
use PHPUnit\Framework\TestCase;

class InputDataTest extends TestCase {
	public function testSingleSource():void {
		$data = new InputData([
			"name" => "Alice",
			"gender" => "f",
		]);
		self::assertEquals("Alice", $data["name"]);
		self::assertEquals("f", $data["gender"]);
	}

	public function testMultipleSources():void {
		$data = new InputData([
			"name" => "Alice",
			"gender" => "f",
		], [
			"do" => "save",
			"userAccess" => "admin",
		]);

		self::assertEquals("Alice", $data["name"]);
		self::assertEquals("f", $data["gender"]);
		self::assertEquals("save", $data["do"]);
		self::assertEquals("admin", $data["userAccess"]);
	}

	public function testAddFromEmpty():void {
		$data = new InputData();
		$data->addKeyValue("name", "Bob");
		self::assertEquals("Bob", $data["name"]);
	}

	public function testAddMultipleFromEmpty():void {
		$data = new InputData();
		$data->addKeyValue("name", "Bob");
		$data->addKeyValue("gender", "m");
		self::assertEquals("Bob", $data["name"]);
		self::assertEquals("m", $data["gender"]);
	}

	public function testAddFromExisting():void {
		$data = new InputData([
			"name" => "Charles",
			"gender" => "m",
		], [
			"do" => "save",
			"userAccess" => "admin",
		]);

		$data->addKeyValue("view", "tab1");
		$data->addKeyValue("screenSize", "large");

		self::assertEquals("Charles", $data["name"]);
		self::assertEquals("m", $data["gender"]);
		self::assertEquals("save", $data["do"]);
		self::assertEquals("admin", $data["userAccess"]);
		self::assertEquals("tab1", $data["view"]);
		self::assertEquals("large", $data["screenSize"]);
	}

	public function testRemove():void {
		$data = new InputData([
			"name" => "Debbie",
			"gender" => "f",
		]);

		self::assertEquals("f", $data["gender"]);
		$data->remove("gender");
		self::assertNull($data["gender"]);
	}

	public function testRemoveMany():void {
		$data = new InputData([
			"name" => "Eddie",
			"gender" => "m",
			"userAccess" => "admin",
		]);
		$data->remove("gender", "name");
		self::assertNull($data["name"]);
		self::assertNull($data["gender"]);
		self::assertNotNull($data["userAccess"]);
	}

	public function testRemoveExceptSingle():void {
		$data = new InputData([
			"name" => "Freddie",
			"gender" => "f",
			"userAccess" => "sales",
		]);
		$data->removeExcept("userAccess");
		self::assertNull($data["name"]);
		self::assertNull($data["gender"]);
		self::assertEquals("sales", $data["userAccess"]);
	}

	public function testRemoveExceptMulti():void {
		$data = new InputData([
			"name" => "Emma",
			"gender" => "f",
			"userAccess" => "sales",
		]);
		$data->removeExcept("name", "userAccess");
		self::assertEquals("Emma", $data["name"]);
		self::assertEquals("sales", $data["userAccess"]);
		self::assertNull($data["gender"]);
	}

	public function testIsset():void {
		$data = new InputData([
			"name" => "Gordon",
			"gender" => "m",
			"userAccess" => "support",
		]);
		self::assertTrue(isset($data["name"]));
		self::assertTrue(isset($data["gender"]));
		self::assertFalse(isset($data["creditCard"]));
	}

	public function testSetAsArray():void {
		$data = new InputData([
			"name" => "Hannah",
			"gender" => "f",
		]);
		$data["userAccess"] = "test";
		self::assertEquals("Hannah", $data["name"]);
		self::assertEquals("f", $data["gender"]);
		self::assertEquals("test", $data["userAccess"]);
	}

	public function testUnsetAsArray():void {
		$data = new InputData([
			"name" => "Ian",
			"gender" => "m",
		]);
		self::assertTrue(isset($data["gender"]));
		unset($data["gender"]);
		self::assertFalse(isset($data["gender"]));
		self::assertEquals("Ian", $data["name"]);
	}
}