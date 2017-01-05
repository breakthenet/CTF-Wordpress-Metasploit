<script type="text/javascript">
jQuery(document).ready(function() {
	   //Input control
        jQuery('#{P_VW_NAME}').alphanumeric({allow:" "});
        jQuery('#{P_VW_TITLE}').alphanumeric({allow:".,-_;: "});
        jQuery('#{P_VW_ROWS_PER_PG}').numeric();
        jQuery('{P_VW_TX_COLUMN_TF}').alphanumeric({allow:" "});
	 });
</script>
<form method="post" id="new_view_2" name="new_view_2" action="{VW_NEW_FORM_ACTION}">
	<table class="widefat post fixed">
      <tr>
        <td align="left" valign="top"><table class="widefat post fixed">
    	<thead>
        	<tr bgcolor="#CCCCCC" valign="top">
              <td align="left" scope="row"><strong>{VW_NEW_SETTINGS}</strong></td>
              <td align="left" valign="top"><strong>{VW_NEW_VALUES}</strong></td>
            </tr>
        </thead>
		<tbody>
        	<tr valign="top">
				<td  align="left" scope="row">{VW_NEW_NAME}</td>
				<td align="left" valign="top"><input name="{P_VW_NAME}" type="text" id="{P_VW_NAME}" value="{V_VW_NAME}" maxlength="64"></td>
	        </tr>
            <tr valign="top">
				<td  align="left" scope="row">{VW_NEW_TITLE}</td>
				<td align="left" valign="top"><input name="{P_VW_TITLE}" type="text" id="{P_VW_TITLE}" value="{V_VW_TITLE}" maxlength="64"></td>
	        </tr>
			<tr valign="top">
				<td  align="left" scope="row">{VW_NEW_STYLE}</td>
				<td align="left" valign="top">
                	<select name="{P_VW_STYLE}">
						{VW_NEW_STYLE_OPTIONS}
					</select>                </td>
	        </tr>
			<tr valign="top">
				<td  align="left" scope="row">{VW_NEW_HTML_VALUES}</td>
				<td align="left" valign="top"><input type="checkbox" name="{P_VW_HTML_VALUES}" value="{V_VW_HTML_VALUES}" {V_VW_HTML_VALUES_CHECKED}></td>
	        </tr>
            <tr valign="top">
				<td  align="left" scope="row">{VW_NEW_HEADER}</td>
				<td align="left" valign="top"><input type="checkbox" name="{P_VW_HEADER}" value="{V_VW_HEADER}" {V_VW_HEADER_CHECKED}></td>
	        </tr>
            <tr valign="top">
				<td  align="left" scope="row">{VW_NEW_FOOTER}</td>
				<td align="left" valign="top"><input type="checkbox" name="{P_VW_FOOTER}" value="{V_VW_FOOTER}" {V_VW_FOOTER_CHECKED}></td>
	        </tr>
            <tr valign="top">
				<td  align="left" scope="row">{VW_NEW_ROWS_PER_PG}</td>
				<td align="left" valign="top"><input name="{P_VW_ROWS_PER_PG}" type="text" id="{P_VW_ROWS_PER_PG}" value="{V_VW_ROWS_PER_PG}" maxlength="11"></td>
	        </tr>
		</tbody>
	</table></td>
        <td align="left" valign="top"><table class="widefat post fixed">
          <thead>
            <tr bgcolor="#CCCCCC" valign="top">
              <td align="left" scope="row"><strong>{VW_NEW_COLUMNS}</strong></td>
              <td align="left" valign="top"><strong>{VW_NEW_COL_VISIBLE}</strong></td>
              <td align="left" valign="top"><strong>{VW_NEW_COL_LABEL}</strong></td>
            </tr>
          </thead>
          <tbody>
              {VW_NEW_COLUMNS_OPTIONS}
          </tbody>
        </table></td>
      </tr>
    </table>
	
<p class="submit">
		<input type="hidden" id="{P_VW_ACTION}" name="{P_VW_ACTION}" value="">
        <input type="hidden" id="{P_VW_QY}" name="{P_VW_QY}" value="{V_VW_QY}">
		<input type="submit" class="button-primary" value="{LBL_BTN_ADD}" onmousedown="jQuery('input[name={P_VW_ACTION}]').attr('value', '{V_ADD_ACTION}')">
		<input type="submit" class="button-primary" value="{LBL_BTN_TEST}" onmousedown="jQuery('input[name={P_VW_ACTION}]').attr('value', '{V_TEST_ACTION}')">
	{VW_TEST_RESULT}
  </p>
</form>