
<div class="dieta-recipe-ingredients-block-names" id ="dieta-recipe-ingredients-block-names-<?php print $key; ?>">
  <div class="close-wrapper"><span class="close">Закрыть</span></div>
  <table>
    <tr>
      <td class="categories">
        <ul>
        <?php foreach ($categories as $category): ?>
          <li class="category tid-<?php print $category->tid; ?>"><?php print $category->name; ?> <span class="count">(<?php print $category->count_products; ?>)</span></li>
        <?php endforeach; ?>
        </ul>
      </td>
      <td class="products">
        <ul>
        <?php foreach ($products as $product): ?>
          <li class="product tid-<?php print $product->tid; ?> category-<?php print $product->parents[0]; ?>"><?php print $product->name; ?></li>
        <?php endforeach; ?>
          
        
        </ul>
      </td>
    </tr>
  </table>
  <div class="form-add-product">
    <div class="label">Добавить продукт, которого нет в списке</div>
    <select name="category" class="form-select">
      <?php foreach ($categories as $category): ?>
        <?php if ($category->tid != 0) : ?>
          <option value="<?php print $category->tid; ?>"><?php print $category->name; ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
    <input type="text" name="product_name" class="form-text"/>
    <a class="form-submit button">Добавить</a>
  </div>
</div>
  
