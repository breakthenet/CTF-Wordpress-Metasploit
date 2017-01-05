
{CH_TEST_RESULT}
<!-- <div id="{CH_NEW_CHART_RESIZE}" style="width:100%; height:100%; padding: 10px"> -->
<!-- <table  style="border:1px; border-color:#000000; border-style:solid">
  <tr>
    <td> -->
    <div id="{CH_NEW_CHART_NAME}"></div>
    <!--</td>
  </tr>
</table> -->
    <!-- </div> -->
<script type="text/javascript">
		
		$(function() {
			$.plot($("#{CH_NEW_CHART_PLACEHOLDER_NAME}"), [{CH_NEW_CHART_DATA}], {CH_NEW_CHART_OPTIONS});
		});
		
</script>
<!--{CH_TEST_RESULT}-->
<!-- <div id="{CH_FLOTCHART_RESIZE}" style="width:100%; height:100%; padding: 10px"> -->
<!-- <table  style="border:1px; border-color:#000000; border-style:solid">
  <tr>
    <td> -->
    {CH_NEW_CHART_PLACEHOLDER}
    <!--</td>
  </tr>
</table> -->
    <!-- </div> -->