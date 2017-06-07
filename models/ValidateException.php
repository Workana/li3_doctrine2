<?php
namespace li3_doctrine2\models;

use lithium\data\Entity;

class ValidateException extends \Exception
{
	protected $entity;
	protected $errors;

	public function __construct($entity = null)
    {
		if (empty($entity)) {
			return parent::__construct();
		}

		if ($entity instanceof Entity) {
			$this->entity = $entity;
			$errors = $entity->errors();
		} else if (is_array($entity)) {
			$errors = $entity;
		}

        $this->errors = $this->convertToOldStyle($errors);

		$message = is_string($entity) ? $entity : '';
		if (!empty($this->errors)) {
			$first = current($this->errors);
			$message = is_array($first) ? current($first) : $first;
		}
		parent::__construct($message);
	}

	private function convertToOldStyle(array $errors)
    {
        $oldStyleErrors = [];
        foreach ($errors as $field => $description)
        {
            $oldStyleErrors[$field] = is_array($description) ? array_values($description) : $description;
        }

        return $oldStyleErrors;
    }

	public function getEntity()
    {
		return $this->entity;
	}

	public function setEntity($entity)
    {
		$this->entity = $entity;
	}

	public function getErrors()
    {
		return $this->errors;
	}

	public function setErrors($errors)
    {
		$this->errors = $this->convertToOldStyle($errors);
	}
}
?>