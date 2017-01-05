<form method="post" id="edit_view_1" name="edit_view_1" action="{VW_EDIT_FORM_ACTION}">
	<table>
  		<tbody>
        	<tr>
    			<td align="left" valign="middle">
					<b>{VW_EDIT_QUERY} </b>
				</td>
				<td align="left" valign="middle">
					<select name="{P_VW_QY}">
						{VW_EDIT_QY_OPTIONS}
					</select>
				</td>
                <td align="left" valign="middle">
					<input type="hidden" id="{P_VW_ACTION}" name="{P_VW_ACTION}" value="">
					<input type="submit" class="button-primary" value="{LBL_BTN_SET}" onmousedown="jQuery('input[name={P_VW_ACTION}]').attr('value', '{V_SET_ACTION}')">
                </td>
  			</tr>
			</tbody>
	</table>	
</form>