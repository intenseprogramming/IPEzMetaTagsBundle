<?php
/**
 * @category  PHP
 * @package   intense-programming
 * @version   1
 * @date      03/08/2015 19:10
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */

/**
 * Class IpEzMetatagsType.
 *
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */
class IpEzMetatagsType extends eZDataType
{

    const DATA_TYPE_STRING = 'ipezmetatags';

    /**
     * Setting the configuration.
     */
    public function __construct()
    {
        $this->eZDataType(
            self::DATA_TYPE_STRING,
            'IP eZ Metatags',
            array(
                'serialize_supported' => false
            )
        );
    }

    /**
     * @param eZContentObjectAttribute $objectAttribute
     * @param integer                  $currentVersion
     * @param eZContentObjectAttribute $originalContentObjectAttribute
     */
    public function postInitializeObjectAttribute($objectAttribute, $currentVersion, $originalContentObjectAttribute)
    {
        /** @var array $originalContent */
        $originalContent = $originalContentObjectAttribute->content();

        if ($originalContent) {
            $objectAttribute->setContent($originalContent);
        } else {
            $objectAttribute->setAttribute(
                'data_text',
                json_encode(
                    array(
                        'description' => array(
                            'content' => $objectAttribute->object()->ID,
                            'field' => null
                        ),
                        'image' => array(
                            'content' => $objectAttribute->object()->ID,
                            'field' => null
                        )
                    )
                )
            );
        }
    }

    /**
     * Defines if the attribute is indexable.
     *
     * @return boolean
     */
    public function isIndexable()
    {
        return false;
    }

    /**
     * Defines if the attribute can be used as an information-collector.
     *
     * @return boolean
     */
    public function isInformationCollector()
    {
        return false;
    }

    /**
     * Storing input.
     *
     * @param eZHTTPTool              $http
     * @param string                  $base
     * @param eZContentClassAttribute $classAttribute
     *
     * @return boolean
     */
    public function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        $attributeBase = $base . '_ipezmetatags_' . $classAttribute->attribute('id');
        $attributeSettings = $http->postVariable($attributeBase);

        if (isset($attributeSettings['type']) && !empty($attributeSettings['type'])) {
            $classAttribute->setAttribute('data_text5', serialize($attributeSettings));

            return true;
        }

        return false;
    }

    /**
     * @param eZContentClassAttribute $classAttribute
     *
     * @return array|string[]
     */
    public function classAttributeContent( $classAttribute )
    {
        return unserialize($classAttribute->attribute('data_text5'));
    }

    /**
     * Storing input.
     *
     * @param eZHTTPTool               $http
     * @param string                   $base
     * @param eZContentObjectAttribute $contentObjectAttribute
     *
     * @return bool|void
     */
    public function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        // TODO: add proper validation.
        $attributeBase = $base . '_ipezmetatags_' . $contentObjectAttribute->attribute('id');

        if (!$http->hasPostVariable($attributeBase)) {
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * Storing input.
     *
     * @param eZHTTPTool               $http
     * @param string                   $base
     * @param eZContentObjectAttribute $contentObjectAttribute
     *
     * @return boolean|void
     */
    public function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $attributeBase = $base . '_ipezmetatags_' . $contentObjectAttribute->attribute('id');

        $contentObjectAttribute->setAttribute('data_text', json_encode($http->postVariable($attributeBase)));

        return true;
    }

    /**
     * Returns the attribute content.
     *
     * @param eZContentObjectAttribute $contentObjectAttribute
     *
     * @return array|string[]
     */
    public function objectAttributeContent( $contentObjectAttribute )
    {
        return json_decode($contentObjectAttribute->attribute('data_text'), true);
    }

    /**
     * Handles custom object-attribute-actions.
     *
     * @param eZHTTPTool               $http
     * @param string                   $action
     * @param eZContentObjectAttribute $contentObjectAttribute
     * @param array                    $parameters
     *
     * @return void
     */
    public function customObjectAttributeHTTPAction($http, $action, $contentObjectAttribute, $parameters)
    {
        if (strpos($action, 'browse_source_object_') === 0) {
            $attribute = $contentObjectAttribute->attribute('id');

            $fieldType = substr($action, 21);
            $browseType = ucfirst($fieldType);
            $browseResponse = 'CustomActionButton[' . $attribute . '_add_source_object_' . $fieldType . ']';

            $module = $parameters['module'];
            $redirectionURI = $parameters['current-redirection-uri'];

            $ini = eZINI::instance('ipmetatags.ini');

            $classConstraintList = $ini->variable('MetaTagSetting', 'Allowed' . $browseType . 'Classes');

            $object = $contentObjectAttribute->object();

            $browseParameters = array(
                'action_name' => 'AddRelatedObject_' . $attribute,
                'type' => 'IPMetaTagsListBrowse',
                'browse_custom_action' => array(
                    'name' => $browseResponse,
                    'value' => $attribute
                ),
                'persistent_data' => array(
                    'HasObjectInput' => 0
                ),
                'from_page' => $redirectionURI,
                'start_node' => eZContentBrowse::nodeAliasID($object->mainNodeID())
            );

            $object->mainNodeID();
            if (count($classConstraintList) > 0) {
                $browseParameters['class_array'] = $classConstraintList;
            }

            eZContentBrowse::browse($browseParameters, $module);
        } elseif (strpos($action, 'add_source_object_') === 0) {
            $fieldType = substr($action, 18);

            if ($http->hasPostVariable('SelectedNodeIDArray')) {
                $selection = $http->postVariable('SelectedNodeIDArray');
                if (isset($selection[0])) {
                    $selection = $selection[0];
                }

                if (is_numeric($selection)) {
                    $node = eZContentObjectTreeNode::fetch($selection);
                    if ($node instanceof eZContentObjectTreeNode) {
                        $selectionObject = $node->object();

                        $attributeContent = $contentObjectAttribute->content();
                        $attributeContent[$fieldType]['content'] = $selectionObject->attribute('id');

                        $contentObjectAttribute->setContent($attributeContent);
                        $contentObjectAttribute->setAttribute('data_text', json_encode($attributeContent));
                        $contentObjectAttribute->store();
                    }
                }
            }
        }
    }

}

eZDataType::register(IpEzMetatagsType::DATA_TYPE_STRING, 'IpEzMetatagsType');
