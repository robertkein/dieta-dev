
<div class="dieta-recipe-steps-time" id ="dieta-recipe-steps-time-<?php print $key; ?>">
  <input type="text" class="step-time form-text" name="step_time" />
  <div class="step-type-time-wrapper">
    <label for="step-type-time-active-<?php print $key; ?>">
      <input type="radio" class="step-type-time" id="step-type-time-active-<?php print $key; ?>" name="step_time_type" checked="checked">
      <img src="step_type_time_active.png" title="Активное время приготовления. То есть время, в которое совершаются действия над блюдом."/>
    </label>
    <label for="step-type-time-common-<?php print $key; ?>">
      <input type="radio" class="step-type-time" id="step-type-time-common-<?php print $key; ?>" name="step_time_type" >
      <img src="step_type_time_common.png" title="Общее время приготовления. То есть все время, которое потребовалось на данный шаг."/>
    </label>
  </div>
</div>
  
