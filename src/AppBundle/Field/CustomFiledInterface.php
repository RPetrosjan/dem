<?php


namespace AppBundle\Field;


use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;

class CustomFiledInterface implements FieldDescriptionInterface
{

    private $name;
    private $fieldName;


    /**
     * set the field name.
     *
     * @param string $fieldName
     */
    public function setFieldName($fieldName)
    {
        $this->$fieldName = $fieldName;
    }

    /**
     * return the field name.
     *
     * @return string the field name
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set the name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        // TODO: Implement setName() method.
    }

    /**
     * Return the name, the name can be used as a form label or table header.
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->name;
        // TODO: Implement getName() method.
    }

    /**
     * Return the value represented by the provided name.
     *
     * @param string $name
     * @param mixed|null $default
     *
     * @return mixed the value represented by the provided name
     */
    public function getOption($name, $default = null)
    {
        // TODO: Implement getOption() method.
    }

    /**
     * Define an option, an option is has a name and a value.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setOption($name, $value)
    {
        // TODO: Implement setOption() method.
    }

    /**
     * Define the options value, if the options array contains the reserved keywords
     *   - type
     *   - template.
     *
     * Then the value are copied across to the related property value
     */
    public function setOptions(array $options)
    {
        // TODO: Implement setOptions() method.
    }

    /**
     * return options.
     *
     * @return array options
     */
    public function getOptions()
    {
        // TODO: Implement getOptions() method.
    }

    /**
     * return the template used to render the field.
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        // TODO: Implement setTemplate() method.
    }

    /**
     * return the template name.
     *
     * @return string the template name
     */
    public function getTemplate()
    {
        // TODO: Implement getTemplate() method.
    }

    /**
     * return the field type, the type is a mandatory field as it used to select the correct template
     * or the logic associated to the current FieldDescription object.
     *
     * @param string $type
     */
    public function setType($type)
    {
        // TODO: Implement setType() method.
    }

    /**
     * return the type.
     *
     * @return int|string
     */
    public function getType()
    {
        // TODO: Implement getType() method.
    }

    /**
     * set the parent Admin (only used in nested admin).
     */
    public function setParent(AdminInterface $parent)
    {
        // TODO: Implement setParent() method.
    }

    /**
     * return the parent Admin (only used in nested admin).
     *
     * @return AdminInterface
     */
    public function getParent()
    {
        // TODO: Implement getParent() method.
    }

    /**
     * Define the association mapping definition.
     *
     * @param array $associationMapping
     */
    public function setAssociationMapping($associationMapping)
    {
        // TODO: Implement setAssociationMapping() method.
    }

    /**
     * return the association mapping definition.
     *
     * @return array
     */
    public function getAssociationMapping()
    {
        // TODO: Implement getAssociationMapping() method.
    }

    /**
     * return the related Target Entity.
     *
     * @return string|null
     */
    public function getTargetEntity()
    {
        // TODO: Implement getTargetEntity() method.
    }

    /**
     * set the field mapping information.
     *
     * @param array $fieldMapping
     */
    public function setFieldMapping($fieldMapping)
    {
        // TODO: Implement setFieldMapping() method.
    }

    /**
     * return the field mapping definition.
     *
     * @return array the field mapping definition
     */
    public function getFieldMapping()
    {
        // TODO: Implement getFieldMapping() method.
    }

    /**
     * set the parent association mappings information.
     */
    public function setParentAssociationMappings(array $parentAssociationMappings)
    {
        // TODO: Implement setParentAssociationMappings() method.
    }

    /**
     * return the parent association mapping definitions.
     *
     * @return array the parent association mapping definitions
     */
    public function getParentAssociationMappings()
    {
        // TODO: Implement getParentAssociationMappings() method.
    }

    /**
     * set the association admin instance (only used if the field is linked to an Admin).
     *
     * @param AdminInterface $associationAdmin the associated admin
     */
    public function setAssociationAdmin(AdminInterface $associationAdmin)
    {
        // TODO: Implement setAssociationAdmin() method.
    }

    /**
     * return the associated Admin instance (only used if the field is linked to an Admin).
     *
     * @return AdminInterface|null
     */
    public function getAssociationAdmin()
    {
        // TODO: Implement getAssociationAdmin() method.
    }

    /**
     * return true if the FieldDescription is linked to an identifier field.
     *
     * @return bool
     */
    public function isIdentifier()
    {
        // TODO: Implement isIdentifier() method.
    }

    /**
     * return the value linked to the description.
     *
     * @param mixed $object
     *
     * @return bool|mixed
     */
    public function getValue($object)
    {
        // TODO: Implement getValue() method.
    }

    /**
     * set the admin class linked to this FieldDescription.
     */
    public function setAdmin(AdminInterface $admin)
    {
        // TODO: Implement setAdmin() method.
    }

    /**
     * @return AdminInterface the admin class linked to this FieldDescription
     */
    public function getAdmin()
    {
        // TODO: Implement getAdmin() method.
    }

    /**
     * merge option values related to the provided option name.
     *
     *
     * @param string $name
     *
     * @throws \RuntimeException
     */
    public function mergeOption($name, array $options = [])
    {
        // TODO: Implement mergeOption() method.
    }

    /**
     * merge options values.
     */
    public function mergeOptions(array $options = [])
    {
        // TODO: Implement mergeOptions() method.
    }

    /**
     * set the original mapping type (only used if the field is linked to an entity).
     *
     * @param string|int $mappingType
     */
    public function setMappingType($mappingType)
    {
        // TODO: Implement setMappingType() method.
    }

    /**
     * return the mapping type.
     *
     * @return int|string
     */
    public function getMappingType()
    {
        // TODO: Implement getMappingType() method.
    }

    /**
     * return the label to use for the current field.
     *
     * @return string
     */
    public function getLabel()
    {
        // TODO: Implement getLabel() method.
    }

    /**
     * Return the translation domain to use for the current field.
     *
     * @return string
     */
    public function getTranslationDomain()
    {
        // TODO: Implement getTranslationDomain() method.
    }

    /**
     * Return true if field is sortable.
     *
     * @return bool
     */
    public function isSortable()
    {
        // TODO: Implement isSortable() method.
    }

    /**
     * return the field mapping definition used when sorting.
     *
     * @return array the field mapping definition
     */
    public function getSortFieldMapping()
    {
        // TODO: Implement getSortFieldMapping() method.
    }

    /**
     * return the parent association mapping definitions used when sorting.
     *
     * @return array the parent association mapping definitions
     */
    public function getSortParentAssociationMapping()
    {
        // TODO: Implement getSortParentAssociationMapping() method.
    }

    /**
     * @param object|null $object
     * @param string $fieldName
     *
     * @return mixed
     */
    public function getFieldValue($object, $fieldName)
    {
        // TODO: Implement getFieldValue() method.
    }
}