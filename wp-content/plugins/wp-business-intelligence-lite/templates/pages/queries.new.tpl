<script type="text/javascript">
jQuery(document).ready(function() {
	   //Input control
	   jQuery('#{P_QY_NAME}').alphanumeric({allow:" "});
	 });
</script>

<form method="post" id="new_query" name="new_query" action="{QY_NEW_FORM_ACTION}">
	<table>
  		<tbody>
        	<tr>
    			<td align="left" valign="middle">
					<b>{QY_NEW_CONNECTION} </b>
				</td>
				<td align="left" valign="middle">
					<select name="{P_QY_DB}">
						{QY_NEW_DB_OPTIONS}
					</select>
				</td>
  			</tr>
			<tr>
    			<td align="left" valign="middle"><b>{QY_NEW_NAME}</b></td>
    			<td align="left" valign="middle"><input name="{P_QY_NAME}" type="text" id="{P_QY_NAME}" value="{V_QY_NAME}" maxlength="256"></td>
  			</tr>
  			<tr>
    			<td align="left" valign="middle"><b>{QY_NEW_STMT}</b></td>
    			<td align="left" valign="middle"><textarea cols="45" rows="5" name="{P_QY_STMT}">{V_QY_STMT}</textarea></td>
                <td rowspan="2">
                    <p style="font-weight: bold;">You can use these parameters to make your query dependent on runtime WP variables.</p>
                    <ul>
                        <li><span style="font-weight: bold;">&#123;&#123;&#123;user_ID&#125;&#125;&#125;:</span> the current user ID</li>
                        <li><span style="font-weight: bold;">&#123;&#123;&#123;user_login&#125;&#125;&#125;:</span> the current user login</li>
                        <li><span style="font-weight: bold;">&#123;&#123;&#123;user_email&#125;&#125;&#125;:</span> the current user email address</li>
                        <li><span style="font-weight: bold;">&#123;&#123;&#123;page_id&#125;&#125;&#125;:</span> the current page id</li>
                    </ul>

                </td>
  			</tr>
			</tbody>
	</table>
	<p class="submit">
		<input type="hidden" id="{P_QY_ACTION}" name="{P_QY_ACTION}" value="">
		<input type="submit" class="button-primary" value="{LBL_BTN_ADD}" onmousedown="jQuery('input[name={P_QY_ACTION}]').attr('value', '{V_ADD_ACTION}')">
		<input type="submit" class="button-primary" value="{LBL_BTN_TEST}" onmousedown="jQuery('input[name={P_QY_ACTION}]').attr('value', '{V_TEST_ACTION}')">
	</p>
</form>