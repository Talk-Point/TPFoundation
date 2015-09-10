<?php /** Updatet die Propertys eines Objektes anhand eines Arrays */

namespace TPFoundation\Foundation;

use ReflectionClass;
use ReflectionProperty;

trait PropertyArrayUpdate
{
    /**
     * Updatet anhand eines Array alle Propertys
     *
     * Es werden alle Elemente des Arrays durchgegeangen und dann kontrolliert ob das protected oder
     * Public Property dazu exestiert, wenn dieses vorhanden ist dann wird der getter des Propertys aufgerufen.
     *
     * @param array $csvArray ['propertyname' => 'value']
     * @param string $class Gibt die genaue Klasse an in der nur Propertys upgedatet werden sollen
     */
    public function updateFromCSVArray($csvArray, $class=null)
    {
        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {

            $class_name = $prop->getDeclaringClass()->getName();
            if (!is_null($class)) {
                if ($class_name != $class) { // Wenn die Klasse nicht genau übereinstimt, dann überspringe das Property
                    continue;
                }
            }

            $property_name = $prop->getName();
            if (array_key_exists($property_name, $csvArray)) {
                $methodName = 'set'.ucfirst($property_name);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($csvArray[$property_name], 'UpdatePropertyArray');
                }
            }
        }
    }
}