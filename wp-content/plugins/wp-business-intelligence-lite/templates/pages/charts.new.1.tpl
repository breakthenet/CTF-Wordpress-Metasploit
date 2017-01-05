<form method="post" id="new_chart_1" name="new_chart_1" action="{CH_NEW_FORM_ACTION}">
	<table>
  		<tbody>
        	<tr>
    			<td align="left" valign="middle">
					<b>{CH_NEW_QUERY} </b>
				</td>
				<td align="left" valign="middle">
					<select name="{P_CH_QY}">
						{CH_NEW_QY_OPTIONS}
					</select>
				</td>
                <td align="left" valign="middle">
					<input type="hidden" id="{P_CH_ACTION}" name="{P_CH_ACTION}" value="">
					<input type="submit" class="button-primary" value="{LBL_BTN_SET}" onmousedown="jQuery('input[name={P_CH_ACTION}]').attr('value', '{V_SET_ACTION}')">
                </td>
  			</tr>
			</tbody>
	</table>	
</form>