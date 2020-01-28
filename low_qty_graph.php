<script type="text/javascript">
$(function () {
        $('#lowqty').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Low Quantity Item/s'
            },
            exporting: { enabled: false },
            subtitle: {
                <?php
                include('connection.php');
                $query="SELECT * FROM tblproducts";
                $get=mysql_query($query);
                $low_qty_count=0;
                while ($row=mysql_fetch_array($get)) {
                    $product_key = $row['id'];
                    $query_low="SELECT * FROM tblproduct_stocks WHERE product_key=$product_key AND status=''";
                    $get_low=mysql_query($query_low) or die(mysql_error());
                    $qty_low=0;
                    while ($row_low=mysql_fetch_array($get_low)) {
                        $qty_low+=$row_low['qty'];
                    }
                    if ($qty_low<=300) {
                        $low_qty_count++;
                    }
                }
                if ($low_qty_count==0)
                {
                    echo "text: 'All Item/s are in Enough Qty'";
                }
                else
                {
                    echo "text: ''";
                }
                mysql_close();
                ?>
            },
            xAxis: {
                categories: [
                    'Items'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Qty'
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
                $query="SELECT * FROM tblproducts";
                $get=mysql_query($query);
                $output='';
                while ($row=mysql_fetch_array($get)) {
                    $product_key = $row['id'];
                    $query_low="SELECT * FROM tblproduct_stocks WHERE product_key=$product_key";
                    $get_low=mysql_query($query_low) or die(mysql_error());
                    $qty_low=0;
                    while ($row_low=mysql_fetch_array($get_low)) {
                        $qty_low+=$row_low['qty'];
                    }
                    if ($qty_low<=300) {
                        if ($low_qty_count>1)
                        {
                            $output .="{name:'".$row['brand_name']."', data: [".$qty_low."]},";
                        }
                        else
                        {
                            $output .="{name:'".$row['brand_name']."', data: [".$qty_low."]}";
                        }   
                    }
                }
				echo $output;
				mysql_close();
				?>
            	]
        });
    });
</script>
<div id="lowqty" style="min-width: 310px; height: 400px; margin: 0 auto"></div>