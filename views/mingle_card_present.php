<style>
div.mingle { background-color: #fff; width:300px; border: solid 1px #ccc; border-left: solid 6px #FF8400; padding: 1em;}
.mingle h4, .mingle h5 { margin-top: 0; }
.mingle h4 { margin-bottom: 0; }
.mingle a, { color: #000; }
.mingle ul { list-style-type: none; margin:0; padding:0; }
.mingle ul li { font-size: 0.9em; }
</style>
<table class="width100" cellspacing="1">
  <tbody>
    <tr>
      <td width="15%" class="form-title" colspan="2"><?php echo plugin_lang_get('title') ?></td>
    </tr>
    <tr class="row-2">
      <td class="category" width="25%"><?php echo plugin_lang_get('view_in_mingle') ?></td>
      <td width="75%">
        <div class="mingle">
          <ul>
              <h4>
                <a href="<?php echo $urlCard ?>" target="_blank">
                  <?php echo $card['name'] ?>
                </a>
              </h4>
              <h5><?php echo $card['type'] ?> #<?php echo $card['number'] ?></h5>
<?php foreach ($card as $attribute => $value): ?>
  <?php if (in_array($attribute, array('name', 'type', 'number')) || empty($value)): continue; endif ?>
          <li>
            <strong><?php echo $attribute ?></strong> : <?php echo $value ?>
          </li>
<?php endforeach ?>
          </ul>
        </div>
      </td>
    </tr>
  </tbody>
</table>