# Excerpt Plugin (for EE3/EE4)
Strips tags of whatever is in the tag pair and trunciates the remaining text. It's a fork of the [obscenely useful EE2 plugin](https://github.com/thinkclay/ExpressionEngine-Excerpt-Plugin) by [@thinkclay](https://github.com/thinkclay), but heavily modified for EE3/EE4 and PHP 7.

This one also sanitizes tag input through EE's `security->xss_clean()` method and performs stricter validation on parameter values.

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
> Hello...

```{exp:excerpt limit="2" indicator="..."}Hello World{/exp:excerpt}```
> Hello World

### limit="number"
The `limit` parameter lets you specify how many words or characters to return. Defaults to 100 if left undefined.

```{exp:excerpt limit="1"}Hello World{/exp:excerpt}```
> Hello

### limit_type="words|chars"
The `limit_type` parameter lets you specify if you want to limit to words (`words`) or characters (`chars`).  

When limiting to characters, the plugin returns whole words, so the actual number of characters might be slightly larger. 

```{exp:excerpt limit="2" limit_type="chars"}Hello World{/exp:excerpt}```
>Hello

## Examples

### Meta Descriptions
One thing this helps with is to spit out dynamically generated meta and Open Graph descriptions for your entries, with a manual override in the entry editor.

Create a basic text input field for your channel (`{entry_description}` in this example, make sure the formatting option is set to **None**) so you can manually define the description on an entry-by-entry basis if desired.

With `{exp:excerpt}` wrapped around whatever fieldtype contains your page content, you can make sure EE will generate descriptions automatically if the field is left empty for that entry:

```
{if entry_description !=''}
<meta name="description" content="{entry_description}">
<meta property="og:description" content="{entry_description}">
{if:else}
<meta name="description" content="{exp:excerpt limit='40' limit_type='words' indicator='...'}{EXAMPLE_BODY_FIELD}{/exp:excerpt}">
<meta property="og:description" content="{exp:excerpt limit='40' limit_type='words' indicator='...'}{EXAMPLE_BODY_FIELD}{/exp:excerpt}">
{/if}
```

## Changelog

### 2.1
**9/1/2018**
- Overall partial rewrite to ensure compatibility for EE 4.3.4 and PHP 7.2.
- Plugin code simplified to a single function. `clean($str)` no longer a separate function.
- Tag data and parameters now run through EE's `security->xss_clean()` method.
- `limit` parameter now validated by `ctype_digit` instead of `is_numeric`
- `limit` now defaults to 100 instead of 500.
- Stricter validation of `limit_type` parameter.
- Errors now logged to developer log.

### 2.0
**6/26/2018**
- Initial release of fork.