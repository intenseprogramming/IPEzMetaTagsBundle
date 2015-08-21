{def $http_base = concat( 'ContentClass_ipezmetatags_', $class_attribute.id )}

{def $allowed_types = hash(
    'Common', hash(
        'article', 'Article',
        'place', 'Place',
        'profile', 'Profile'
    ),
    'Books', hash(
        'books.author', 'Author',
        'books.book', 'Book',
        'books.genre', 'Genre'
    ),
    'Business', hash(
        'business.business', 'Business'
    ),
    'Fitness', hash(
        'fitness.course', 'Course'
    ),
    'Game', hash(
        'game.achievement', 'Achievement'
    ),
    'Music', hash(
        'music.album', 'Album',
        'music.playlist', 'Playlist',
        'music.radio_station', 'Radio Station',
        'music.song', 'Song'
    ),
    'Product', hash(
        'product', 'Product',
        'product.group', 'Group',
        'product.item', 'Item'
    ),
    'Restaurant', hash(
        'restaurant.restaurant', 'Restaurant',
        'restaurant.menu', 'Menu',
        'restaurant.menu_item', 'Item',
        'restaurant.menu_section', 'Section'
    ),
    'Video', hash(
        'video.episode', 'Episode',
        'video.movie', 'Movie',
        'video.other', 'Other',
        'video.tv_show', 'TV Show'
    )
)}

<div id="DropDownReload_Attribute_{$class_attribute.id}" class="block">
    <label for="{$http_base}">Type</label>
    <select id="{$http_base}" name="{$http_base}[type]">
        {foreach $allowed_types as $key => $value}
            <optgroup label="{$key}">
                {foreach $value as $identifier => $type}
                    <option value="{$identifier}">{$type}</option>
                {/foreach}
            </optgroup>
        {/foreach}
    </select>
</div>