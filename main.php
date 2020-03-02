<?php
/*
* Главный класс фермы
*/
class Farm
{
	/*
	*@array Массив животных объектов
	*/
	public $animalsCollection = [];
	
	/*
	*@array Массив продуктов по типам животных
	*/
	public $productsCollection = [];
	
	/*
	* Создаем животных из массива
	*/
	public function createAnimals(array $animals):void
	{
		foreach ($animals as $type => $value){
			$animalType = $type;
			$animalCount = $value;
			for ($i = 1; $i <= $animalCount; $i++){
				$this->animalsCollection["$animalType"][]= new $animalType();
			}
		}
	}
	
	/*
	* Собираем продукты
	*/
	public function collectionProducts():void
	{
		foreach($this->animalsCollection as $key => $value){
			$product = 0;
			foreach ($value as $animal){
				$product += $animal->getProducts();
			}
			$this->productsCollection["$key"] = $product;
		}
	}
	
	/*
	* Вывод в консоль
	*/
	public function toPrint()
	{
		echo 'Собрано молока '. $this->productsCollection["Cow"] . ' л.'. PHP_EOL;
		echo 'Собрано яиц '. $this->productsCollection["Chicken"] . ' шт.'. PHP_EOL;
	}
}

/*
* Класс хлев
*
*/
class Cowshed extends Farm
{
}

/*
* Класс животного
*
*/
abstract class Animal 
{
	/**
	*@var string Идентификатор животному
	*/
	public $uid;
	
	/*
	* Присваиваем уникальный идентификатор животному
	*/
	public function __construct()
	{
		$this->uid = hash('crc32', microtime()+random_int(0,100));
	}
	
	/*
	*Возвращает случайное количество продуктов
	*@return int
	*/
	abstract public function getProducts();
	
}

/**
* Класс коров
*/
class Cow extends Animal
{
	/**
	*@var int Минимальное кличество генерируемого продукта
	*/
	private const MIN_PRODUCT_COUNT = 8;
	
	/**
	*@var int Максимальное количество генерируемого продукта
	*/
	private const MAX_PRODUCT_COUNT = 12;

	/**
	*Получаем случайное количество продукта min <= N <= max
	*@return int
	*/
	public function getProducts()
	{
		return random_int(self::MIN_PRODUCT_COUNT, self::MAX_PRODUCT_COUNT);
	}

}

/**
* Класс куриц
*/
class Chicken extends Animal
{
	/**
	*@var int Минимальное кличество генерируемого продукта
	*/
	private const MIN_PRODUCT_COUNT = 0;
	
	/**
	*@var int Максимальное количество генерируемого продукта
	*/
	private const MAX_PRODUCT_COUNT = 1;

	/**
	*Получаем случайное количество продукта min <= N <= max
	*@return int
	*/
	public function getProducts():int
	{
		return random_int(self::MIN_PRODUCT_COUNT, self::MAX_PRODUCT_COUNT);
	}
	
}


$factory = new Cowshed();
$factory->createAnimals([
	'Cow' => 10,
	'Chicken' => 20,
]);

$factory->collectionProducts();
$factory->toPrint();
