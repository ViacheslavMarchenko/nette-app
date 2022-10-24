<?php

namespace App\Model;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\GroupedSelection;
use Nette\InvalidStateException;

/**
 * Class AbstractModel
 */
abstract class AbstractModel
{

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * @var ActiveRow
	 */
	private $row;

	/**
	 * @return string
	 */
	abstract public function getTableName(): string;

	/**
	 * @param ActiveRow $row
	 * @return static
	 */
	public function mapValues(ActiveRow $row, string $locale): self
	{
		$this->locale = $locale;
		$this->row = $row;

		foreach ($row->toArray()  as $property => $value) {
			$this->{$this->parseColumnName($property)} = $value;
		}

		if ($this->hasTranslations()) {
			$translation = $this->getTranslation($locale);
			foreach ($this->getTranslationFields() as $field) {
				$this->{$this->parseColumnName($field)} = $translation->{$field};
			}
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasTranslations(): bool
	{
		if (empty($this->getTranslationOptions())) {
			return false;
		}

		$options = $this->getTranslationOptions();
		if (
			!key_exists('translation_table', $options) ||
			!key_exists('translation_relation_column', $options) ||
			!key_exists('translation_fields', $options)
		) {
			throw new InvalidStateException('Translation table is not configured properly.');
		}

		return true;
	}

	/**
	 * @return array
	 */
	public function getTranslationOptions(): array
	{
		return [];
	}

	/**
	 * @return array
	 */
	public function getOriginalValues(): array
	{
		return $this->row->toArray();
	}

	/**
	 * @param string $className
	 * @param string $property
	 * @return GroupedSelection
	 */
	public function getRelated(string $className, string $property): GroupedSelection
	{
		/** @var AbstractModel $class */
		$class = new $className;
		return $this->row->related($class->getTableName(), $property);
	}

	/**
	 * @param string $name
	 * @return string
	 */
	private static function parseColumnName(string $name): string
	{
		return lcfirst(str_replace('_', '', ucwords($name, '_')));
	}

	/**
	 * @return string
	 */
	private function getTranslationTable(): string
	{
		$tableName = $this->getTranslationOptions()['translation_table'];
		return (string) $tableName;
	}

	/**
	 * @return string
	 */
	private function getTranslationRelationColumn(): string
	{
		$tableName = $this->getTranslationOptions()['translation_relation_column'];
		return (string) $tableName;
	}

	/**
	 * @return array
	 */
	protected function getTranslationFields(): array
	{
		$fields = $this->getTranslationOptions()['translation_fields'];
		return (array) $fields;
	}

	/**
	 * @var string $locale
	 * @return ActiveRow
	 */
	private function getTranslation(string $locale): ?ActiveRow
	{
		$translations = $this->row->related(
			sprintf('%s.%s', $this->getTranslationTable(), $this->getTranslationRelationColumn())
		);
		foreach ($translations as $translation) {
			if ($locale === $translation->locale) {
				return $translation;
			}
		}
		return null;
	}
}