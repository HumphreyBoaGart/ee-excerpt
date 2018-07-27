# Excerpt Plugin (for EE3/EE4)
It's literally just the original [obscenely useful EE2 plugin] (https://github.com/thinkclay/ExpressionEngine-Excerpt-Plugin) by @thinkclay, but modified to run on ExpressionEngine 3 and 4.

## Usage
Wrap anything you want to be processed between the tag pairs. This will strip out all tags automatically and do a limit on words after.

```{exp:excerpt limit="50"}text you want processed{/exp:excerpt}```

You can also wrap it around custom fields:

```{exp:excerpt limit="50"}{EXAMPLE_FIELD}{/exp:excerpt}```

## Parameters
Use the following parameters to specify what the plugin should return.

### indicator="string"
The `indicator` parameter can be used to append characters onto the end of the content, if it has been limited.

```{exp:excerpt limit="1" indicator="..."}Hello World{/exp:excerpt}```
Returns:
> Hello...

```{exp:excerpt limit="2" indicator="..."}Hello World{/exp:excerpt}```
Returns:
> Hello World

### limit="number"
The `limit` parameter lets you specify how many words or characters to return. Defaults to 500 if left undefined.

```{exp:excerpt limit="1"}Hello World{/exp:excerpt}```
Returns:
> Hello

### limit_type="words|chars"
The `limit_type` parameter lets you specify if you want to limit to words (`words`) or characters (`chars`).  

When limiting to characters, the plugin returns whole words, so the actual number of charactars might be slightly larger. 

```{exp:excerpt limit="2" limit_type="chars"}Hello World{/exp:excerpt}```
Returns:
>Hello

### indicator="..."
The `indicator` parameter can be used to append characters onto the end of the content, if it has been limited.

## Examples

### Dynamic Meta Descriptions
One incredibly helpful thing you can do with this is to put it in your entry template. Create a basic text input field for your channel (`{entry_description}` in this example, make sure the formatting option is set to **None**) so you can manually define the description on an entry-by-entry basis if desired.

With `{exp:excerpt}` wrapped around whatever fieldtype contains your page content, you can make sure EE can generate descriptions automatically if the field is left empty for that entry:

```<meta name="description" content="{if entry_description !=''}{entry_description}{if:else}{exp:excerpt limit='40' limit_type='words' indicator='...'}{EXAMPLE_BODY_FIELD}{/exp:excerpt}{/if}">```
```<meta property="og:description" content="{if entry_description !=''}{entry_description}{if:else}{exp:excerpt limit='40' limit_type='words' indicator='...'}{EXAMPLE_BODY_FIELD}{/exp:excerpt}{/if}">```

## Changelog

### Version 2.0
- Initial release