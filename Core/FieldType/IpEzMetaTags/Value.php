<?php
/**
 * @category  PHP
 * @package   intense-programming
 * @version   1
 * @date      02/08/2015 18:07
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */

namespace IntenseProgramming\EzMetaTagsBundle\Core\FieldType\IpEzMetaTags;

use eZ\Publish\API\Repository\Exceptions\NotImplementedException;
use eZ\Publish\Core\FieldType\Value as BaseValue;

/**
 * Class Value.
 *
 * @package   IntenseProgramming\EzMetaTagsBundle\Core\FieldType\IpEzMetaTags
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */
class Value extends BaseValue
{

    /**
     * @var string
     */
    protected $textRepresentation;

    /**
     * @var integer|null
     */
    public $descriptionContentId;

    /**
     * @var string|null
     */
    public $descriptionFieldIdentifier;

    /**
     * @var integer|null
     */
    public $imageContentId;

    /**
     * @var string|null
     */
    public $imageFieldIdentifier;

    /**
     * @param array $textRepresentation
     */
    public function __construct($textRepresentation = null)
    {
        parent::__construct(array());

        $this->textRepresentation = $textRepresentation;
    }

    /**
     * Returns a string representation of the field value.
     *
     * @return string
     *
     * @throws NotImplementedException
     */
    public function __toString()
    {
        if ($this->textRepresentation) {
            return $this->textRepresentation;
        }

        throw new NotImplementedException('Meta-Tags-Field has no string representation.');
    }

}
