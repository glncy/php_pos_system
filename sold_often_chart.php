<script type="text/javascript">
$(function () {
        $('#soldoften').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Often Sold Items'
            },
            exporting: { enabled: false },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Items'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sold'
                }
            },
            /*tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },*/
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
            	enabled: false
            },
            series: [
            	<?php
				include('connection.php');
				$query="SELECT * FROM tblproducts ORDER BY sold desc limit 20";
				$get=mysql_query($query);
				$num_row=mysql_num_rows($get);
				$output='';
				while ($row = mysql_fetch_array($get)) {
					$id=$row['id'];
					if ($num_row>1)
					{
						$output .="{name:'".$row['brand_name']."', data: [".$row['sold']."]},";
					}
					else
					{
						$output .="{name:'".$row['brand_name']."', data: [".$row['sold']."]}";
					}	
				}
				echo $output;
				mysql_close();
				?>
            	]
        });
    });
</script>
<div id="soldoften" style="min-width: 310px; height: 400px; margin: 0 auto"></div>