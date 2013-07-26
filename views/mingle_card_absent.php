<br />
<table class="width100" cellspacing="1">
  <tbody>
    <tr>
      <td width="15%" class="form-title" colspan="2"><?php echo plugin_lang_get('title') ?></td>
    </tr>
    <tr class="row-2">
      <td class="category" width="25%"><?php echo plugin_lang_get('send_to_mingle') ?></td>
      <td width="75%">
        <form method="post" target="_blank" action="<?php echo $mingleUrl ?>/api/v2/projects/<?php echo $mingleProject ?>/cards.xml">
          <!-- Common card attributes --> 
          <input type="hidden" name="card[card_type_name]" value="<?php echo $mingleCardType ?>" />
          <input type="hidden" name="card[name]" value="[MANTIS-<?php echo $mantisBug->id ?>] <?php echo $mantisBug->summary ?>" />
          <input type="hidden" name="card[description]" value="<?php echo $mantisBug->description ?>" />
          <!-- Card properties -->
          <input type="hidden" name="card[properties][][name]" value="Mantis Issue ID" />
          <input type="hidden" name="card[properties][][value]" value="<?php echo $mantisBug->id ?>" />
          <input type="hidden" name="card[properties][][name]" value="Mantis Issue URL" />
          <input type="hidden" name="card[properties][][value]" value="<?php echo $mantisUrl ?>" />
          <!-- Submit button -->
          <input type="submit" value='Create new "<?php echo $mingleCardType ?>" in Mingle project "<?php echo $mingleProject ?>" at "<?php echo $mingleUrl ?>"' />
        </form>
      </td>
    </tr>
  </tbody>
</table>