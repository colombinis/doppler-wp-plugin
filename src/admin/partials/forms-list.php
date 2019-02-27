<h1><?php _e('Forms List', 'doppler-form')?></h1>
<div class="dplr">
  <div class="panel">
    <div class="">
      <table class="fixed">
        <thead>
          <tr>
            <th class="col-id"><?php _e('Id', 'doppler-form')?></th>
            <th class="col-title"><?php _e('Title', 'doppler-form')?></th>
            <th class="col-listname"><?php _e('List Name', 'doppler-form')?></th>
            <th class="col-listid"><?php _e('List Id', 'doppler-form')?></th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i=0; $i <count($forms) ; $i++) {
            $form = $forms[$i];?>
          <tr>
            <td><?= $form->id; ?></td>
            <td>
              <a href="<?php echo str_replace('[FORM_ID]', $form->id , $edit_form_url); ?>" class="bold"> <?php echo $form->title; ?></a>
              <div class="column-actions">
                <a href="<?php echo str_replace('[FORM_ID]', $form->id , $edit_form_url); ?>"><?php _e('Edit', 'doppler-form')?></a> |
                <a href="<?php echo str_replace('[FORM_ID]', $form->id , $delete_form_url); ?>" class="dplr-remove"><?php _e('Delete', 'doppler-form')?></a>
              </div>
            </td>
            <td><?php echo $dplr_lists_arr[$form->list_id] ?></td>
            <td><?php echo $form->list_id; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<a href="<?php echo $create_form_url; ?>" class="button button-primary"><?php _e('New Form', 'doppler-form')?></a>

<div id="dplr-dialog-confirm" title="<?php _e('Confirmation Required', 'doppler-form'); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span> <?php _e('This item will be permanently deleted and cannot be recovered. Are you sure?', 'doppler-form')?></p>
</div>