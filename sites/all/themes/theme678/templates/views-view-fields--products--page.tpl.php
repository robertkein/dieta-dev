<?php
/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<div class="image_product">
    <?php print $fields["field_image"]->content; ?>
</div>
<table>
    <tr style="background:#cccccc;">
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_proteins"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_proteins"]->content; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_fats"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_fats"]->content; ?></td>
    </tr>
    <tr style="background:#cccccc;">
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_carbohydrates"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_carbohydrates"]->content; ?></td>
    </tr>
    <tr >
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_ca"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_ca"]->content; ?></td>
    </tr>
    <tr style="background:#cccccc;">
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_k"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_k"]->content; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_na"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_na"]->content; ?></td>
    </tr>
    <tr style="background:#cccccc;">
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_caloric_effect"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_caloric_effect"]->content; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_glycemic_index"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_glycemic_index"]->content; ?></td>
    </tr>
    <tr style="background:#cccccc;">
        <td style="text-align: left;padding: 0;">  <?php print $fields["field_product_price"]->label_html; ?></td>
        <td style="text-align: right;"> <?php print $fields["field_product_price"]->content; ?></td>
    </tr>
</table>
<div class="decription_product">
    <?php print $fields["description"]->content; ?>
</div>


<div id="social_block_products" style="">
    <div class="title_like">Расскажите друзьям о полезных качествах продукта:</div>
    <script type="text/javascript" src="//yandex.st/share/share.js"
    charset="utf-8"></script>
    <div class="yashare-auto-init" data-yashareL10n="ru"
         data-yashareType="none" data-yashareQuickServices="gplus,vkontakte,facebook,twitter">
    </div>
</div>
</script>


