<script type="text/javascript">
jQuery(document).ready(function() {
	   //Input control
	   jQuery('#{P_QY_NAME}').alphanumeric({allow:" "});
	 });
</script>
<form method="post" id="edit_query" name="edi_query" action="{QY_EDIT_FORM_ACTION}">
	<table>
  		<tbody>
        	<tr>
    			<td align="left" valign="middle">
					<b>{QY_EDIT_CONNECTION} </b>
				</td>
				<td align="left" valign="middle">
					<select name="{P_QY_DB}">
						{QY_EDIT_DB_OPTIONS}
					</select>
				</td>
  			</tr>
			<tr>
    			<td align="left" valign="middle"><b>{QY_EDIT_NAME}</b></td>
    			<td align="left" valign="middle"><input name="{P_QY_NAME}" type="text" id="{P_QY_NAME}" value="{V_QY_NAME}" maxlength="256"></td>
  			</tr>
  			<tr>
    			<td align="left" valign="middle"><b>{QY_EDIT_STMT}</b></td>
    			<td align="left" valign="middle"><textarea cols="45" rows="5" name="{P_QY_STMT}">{V_QY_STMT}</textarea></td>
  			</tr>
			</tbody>
	</table>
	<p class="submit">
		<input type="hidden" id="{P_QY_ACTION}" name="{P_QY_ACTION}" value="">
        <input type="hidden" id="{P_QY_ID}" name="{P_QY_ID}" value="{V_QY_ID}">
		<input type="submit" class="button-primary" value="{LBL_BTN_SAVE}" onmousedown="jQuery('input[name={P_QY_ACTION}]').attr('value', '{V_EDIT_ACTION}')">
		<input type="submit" class="button-primary" value="{LBL_BTN_TEST}" onmousedown="jQuery('input[name={P_QY_ACTION}]').attr('value', '{V_TEST_ACTION}')">
	</p>
</form>