<script type="text/javascript" charset="utf-8">
    jQuery(document).ready(function() {
        jQuery('#{TABLE_STYLE}').dataTable( {
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        } );
    } );
</script>
<table class="#" id="#" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:transparent; background-color:transparent; width:0%; height:0%; border:0px;">
	<tr>
		<td>
			{TABLE_TITLE}
		</td>
	</tr>
	<tr>
		<td>
			{TABLE_PAGINATION}
		</td>
	</tr>
	<tr>
		<td>
			<table class="{TABLE_CLASS}" id="{TABLE_STYLE}">
				<colgroup>
		    		<col >
					<col class="emphasis">
				</colgroup>
				<thead>
					<tr>
						{TABLE_HEADER}			
			        </tr>
				</thead>
				<tfoot>
					<tr>
						{TABLE_FOOTER}			
			        </tr>
				</tfoot>
				<tbody>
			      	{TABLE_BODY}
				</tbody>
			</table>
		</td>
	</tr>
    <!-- Pagination on footer -->
    <tr>
		<td>
			{TABLE_PAGINATION}
		</td>
	</tr> 
</table>