<?php
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

html_page_top( plugin_lang_get( 'title' ) );

print_manage_menu( );

?>

<br />

<form action="<?php echo plugin_page( 'config_edit' )?>" method="post">
<?php echo form_security_field( 'plugin_MingleIntegration_config_edit' ) ?>
  <table align="center" class="width75" cellspacing="1">

    <tr>
      <td class="form-title" colspan="3">
        <?php echo plugin_lang_get( 'title' ) . ' : ' . plugin_lang_get( 'config' )?>
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'mingle_url_instance' )?>
      </td>
      <td  colspan="2">
        <input type="text" name="mingle_url_instance" value="<?php echo plugin_config_get( 'mingle_url_instance' )?>" />
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'mingle_username' )?>
      </td>
      <td  colspan="2">
        <input type="text" name="mingle_username" value="<?php echo plugin_config_get( 'mingle_username' )?>" />
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'mingle_password' )?>
      </td>
      <td  colspan="2">
        <input type="password" name="mingle_password" value="<?php echo plugin_config_get( 'mingle_password' )?>" />
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'project' )?>
      </td>
      <td  colspan="2">
        <input type="text" name="project" value="<?php echo plugin_config_get( 'project' )?>" />
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'default_card_type' )?>
      </td>
      <td  colspan="2">
        <input type="text" name="default_card_type" value="<?php echo plugin_config_get( 'default_card_type' )?>" />
      </td>
    </tr>

    <tr <?php echo helper_alternate_class( )?>>
      <td class="category">
        <?php echo plugin_lang_get( 'additional_card_attributes' )?>
      </td>
      <td  colspan="2">
        <p>Complex option types must be set using the <a href="adm_config_report.php">Configuration Report</a> screen.</p>
        <p>
          Option name is <strong>plugin_MingleIntegration_additional_card_attributes</strong> and is an array of Mingle card attributes names.
          Attributes that contain a space character must be enclosed in quotes.
        </p>
        <p>
          For instance : <pre>array(Assigned To, Completion Status, Remaining Value)</pre>
        </p>
      </td>
    </tr>

    <tr>
      <td class="center" colspan="3">
        <input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' )?>" />
      </td>
    </tr>

  </table>
</form>

<?php
html_page_bottom();
