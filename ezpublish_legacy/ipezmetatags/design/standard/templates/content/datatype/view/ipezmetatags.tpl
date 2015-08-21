
<table>
    <tr>
        <th>Source</th>
        <th>Attribute</th>
        <th>Value</th>
    </tr>
    <tr>
        {def $description = fetch('content', 'object', hash('object_id', $attribute.content.description.content))}
        <td>{node_view_gui content_node=$description.main_node view='line' node_url=true()}</td>
        <td>{$attribute.content.description.field}</td>
        <td>{attribute_view_gui attribute=$description.data_map[$attribute.content.description.field]}</td>
    </tr>
    <tr>
        {def $image = fetch('content', 'object', hash('object_id', $attribute.content.image.content))}
        <td>{node_view_gui content_node=$image.main_node view='line' node_url=true()}</td>
        <td>{$attribute.content.image.field}</td>
        <td>{attribute_view_gui attribute=$image.data_map[$attribute.content.image.field]}</td>
    </tr>
</table>
