<?php
namespace Gt\Input\InputData\Test;

use Gt\Input\Input;
use Gt\Input\InputData\InputDataFactory;
use Gt\Input\WithWithoutClashingException;
use PHPUnit\Framework\TestCase;

class InputDataFactoryTest extends TestCase {
	public function testCreateNoCriteria():void {
		$input = $this->createInput();
		$data = InputDataFactory::create($input);
		self::assertEquals("Edward", $data["name"]);
		self::assertEquals("51", $data["age"]);
		self::assertEquals("01234 567890", $data["telephone"]);
		self::assertEquals("AB12 3CD", $data["postcode"]);
	}

	public function testCreateCriteriaWith():void {
		$input = $this->createInput();
		$data = InputDataFactory::create($input, ["name", "postcode"]);
		self::assertEquals("Edward", $data["name"]);
		self::assertNull($data["age"]);
		self::assertNull($data["telephone"]);
		self::assertEquals("AB12 3CD", $data["postcode"]);
	}

	public function testCreateCriteriaWithout():void {
		$input = $this->createInput();
		$data = InputDataFactory::create($input, [],["age", "telephone"]);
		self::assertEquals("Edward", $data["name"]);
		self::assertNull($data["age"]);
		self::assertNull($data["telephone"]);
		self::assertEquals("AB12 3CD", $data["postcode"]);
	}

	public function testCreateCriteriaWithWithoutNoClash():void {
		$input = $this->createInput();
		$data = InputDataFactory::create($input, ["name"], ["postcode"]);
		self::assertEquals("Edward", $data["name"]);
		self::assertNull($data["age"]);
		self::assertNull($data["telephone"]);
		self::assertNull($data["postcode"]);
	}

	public function testCreateCriteriaWithWithoutClash():void {
		$input = $this->createInput();
		self::expectException(WithWithoutClashingException::class);
		InputDataFactory::create($input, ["name", "age"], ["age"]);
	}

	protected function createInput() {
		return new Input([
			"name" => "Edward",
			"age" => 51,
			"telephone" => "01234 567890",
			"postcode" => "AB12 3CD",
		]);
	}
}