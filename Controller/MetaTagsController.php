<?php
/**
 * @category  PHP
 * @package   intense-programming
 * @version   1
 * @date      21/08/2015 00:15
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */

namespace IntenseProgramming\EzMetaTagsBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Bundle\EzPublishCoreBundle\Imagine\AliasGenerator;
use eZ\Publish\Core\Repository\Values\Content\Content;
use IntenseProgramming\EzMetaTagsBundle\Core\FieldType\IpEzMetaTags\Value;
use Symfony\Component\BrowserKit\Response;

/**
 * Class MetaTagsController.
 *
 * @package   IntenseProgramming\EzMetaTagsBundle\Controller
 * @author    Konrad, Steve <skonrad@wingmail.net>
 * @copyright 2015 Intense-Programming
 */
class MetaTagsController extends Controller
{

    /**
     * Renders the meta-tags-section depending on the content handed over.
     *
     * @param integer $contentId
     *
     * @return Response
     */
    public function renderAction($contentId)
    {
        /** @var AliasGenerator $aliasGenerator */
        $aliasGenerator = $this->container->get('ezpublish.image_alias.imagine.alias_generator');

        $repository = $this->getRepository();
        $contentService = $repository->getContentService();
        $locationService = $repository->getLocationService();
        $contentTypeService = $repository->getContentTypeService();

        $content = $contentService->loadContent($contentId);
        $location = $locationService->loadLocation($content->contentInfo->mainLocationId);
        $contentType = $contentTypeService->loadContentType($content->contentInfo->contentTypeId);

        $configResolver = $this->getConfigResolver();

        $template = $configResolver->getParameter('template', 'intense.programming.tags');

        if ($content instanceof Content) {
            $templateParameters = array(
                'content' => $content,
                'location' => $location
            );

            // searching for meta-tags field.
            foreach ($content->getFields() as $field) {
                if ($field->value instanceof Value) {
                    /** @var Value $value */
                    $value = $content->getFieldValue($field->fieldDefIdentifier);
                    $fieldDefinition = $contentType->getFieldDefinition($field->fieldDefIdentifier);
                    break;
                }
            }

            // getting type from field definition.
            if (isset($fieldDefinition)) {
                if (isset($fieldDefinition->fieldSettings['type']) && $fieldDefinition->fieldSettings['type']) {
                    $templateParameters['type'] = $fieldDefinition->fieldSettings['type'];
                }
            }

            // getting image and description from linked content.
            if (isset($value)) {
                if ($value->imageContentId) {
                    $imageContent = $contentService->loadContent($value->imageContentId);
                    if ($imageContent instanceof Content && isset($imageContent->fields[$value->imageFieldIdentifier])) {
                        $alias = $configResolver->getParameter('image_alias', 'intense.programming.tags');
                        $imageField = $imageContent->getField($value->imageFieldIdentifier);

                        if (isset($imageField)) {
                            $templateParameters['image'] = array(
                                'url' => $aliasGenerator->getVariation($imageField, $content->versionInfo, $alias)->uri
                            );
                        }
                    }
                }

                if ($value->descriptionContentId) {
                    $descriptionContent = $contentService->loadContent($value->descriptionContentId);
                    if (isset($descriptionContent->fields[$value->descriptionFieldIdentifier])) {
                        $templateParameters['description'] = array(
                            'content' => $descriptionContent,
                            'field' => $value->descriptionFieldIdentifier
                        );
                    }
                }
            }

            return $this->render(
                $template,
                $templateParameters
            );
        }

        return new Response('', 404);
    }

}
