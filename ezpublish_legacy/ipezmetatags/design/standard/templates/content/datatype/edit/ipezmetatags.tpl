{def $http_base = concat( 'ContentObjectAttribute_ipezmetatags_', $attribute.id )}

{def $description = fetch('content', 'object', hash('object_id', $attribute.content.description.content))}
{def $image = fetch('content', 'object', hash('object_id', $attribute.content.image.content))}

<input type="hidden" name="ContentObjectAttribute_browse_for_object_start_node[{$attribute.id}]" value="{$attribute.object.main_node_id}">
<table>
    <tr>
        <th></th>
        <th>
            Source Object
        </th>
        <th>
            Attribute
        </th>
    </tr>
    <tr>
        <th><label for="{$http_base}_description_field">Description:</label></th>
        <td>
            <input type="hidden" name="{$http_base}[description][content]" value="{$attribute.content.description.content}">
            {if eq($attribute.content.description.content, $attribute.object.id)}
                current
            {else}
                {node_view_gui content_node=$description.main_node view='line' node_url=false()}
            {/if}
            <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_browse_source_object_description]" value="{'Change'|i18n( 'design/standard/class/datatype' )}">
        </td>
        <td>
            <select id="{$http_base}_description_field" name="{$http_base}[description][field]">
                <option value="">none</option>
                {foreach $description.content_class.data_map as $desc_identifier => $desc_field}
                    {if array('ezstring', 'eztext')|contains($desc_field.data_type_string)}
                        <option{if $desc_identifier|eq($attribute.content.description.field)} selected="selected"{/if} value="{$desc_identifier}">{$desc_field.name}</option>
                    {/if}
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <th><label for="{$http_base}_image_field"></label>Image:</th>
        <td>
            <input type="hidden" name="{$http_base}[image][content]" value="{$attribute.content.image.content}">
            {if eq($attribute.content.image.content, $attribute.object.id)}
                current
            {else}
                {node_view_gui content_node=$image.main_node view='line' node_url=false()}
            {/if}
            <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_browse_source_object_image]" value="{'Change'|i18n( 'design/standard/class/datatype' )}">
        </td>
        <td>
            <select id="{$http_base}_image_field" name="{$http_base}[image][field]">
                <option value="">none</option>
                {foreach $image.content_class.data_map as $desc_identifier => $desc_field}
                    {if array('ezimage')|contains($desc_field.data_type_string)}
                        <option{if $desc_identifier|eq($attribute.content.image.field)} selected="selected"{/if} value="{$desc_identifier}">{$desc_field.name}</option>
                    {/if}
                {/foreach}
            </select>
        </td>
    </tr>
</table>
