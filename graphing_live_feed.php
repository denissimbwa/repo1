<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, 15000);

</script>

<style>

table {
    border-collapse: collapse;
	width:80%;
}
td {
    height: 50px;
    vertical-align: bottom;
}
table, th, td {
    border: 1px solid black;
}
th, td {
    border-bottom: 1px solid #ddd;
	padding-left:20px;
	padding-right:20px;
}
tr:nth-child(even) {
	background-color: #f2f2f2;
	}
	
</style>






<?php

//Capture flag
$tpe=$_GET['tpe']*1;

//Fetch data from source

@ $rst=$fetched_data=file_get_contents("http://212.88.98.116:4050/");
if(!$rst)
 {
  echo "Sorry !<br> We could not reach the server at http://212.88.98.116:4050/. Data might be temporarily inaccessible.";
  die;
 }
//Check fetched data
//echo "<p>".$fetched_data;

//Load json data into array
$json_array=json_decode($fetched_data,true);
//var_dump($json_array);

//Run through loop
foreach($json_array as $k1 => $v1)
 {
//  echo '<br>'.$k1." :: ".$v1;
//Match data to corresponding graph.
    if($k1==="Cpu"&&$tpe==1)
	      draw_line_graph($v1,$k1." usage");
	else if($k1==="Memory"&&$tpe==2)
		  drawpie_chart($v1,$k1." usage");
 }




//FUNCTIONS DEFINITIONS

//Function for drawing line graphp
function draw_line_graph($values,$title)
  {
  $tpe=$_GET['tpe']*1;   //Ensure tpe takes up integer type
  echo "<p><u><b>Line graph for:</b></u> ".$title."</p>";
  
  table_maker($values);	 
   $g=0;
   $var_string=null;
   foreach($values as $dta_key => $dta_vl)
    {
	 $var_string[]="['".$dta_key."', ".$dta_vl."]";//['".$dta_key."', ".$dta_vl."]";
    }
   $var_string=implode(",",$var_string);
   $type="line";
   if($tpe==1);
      include("draw_line_graph.php");
  }
  
  
//Function for drawing pie chart
function drawpie_chart($values,$title)
  {
  $tpe=$_GET['tpe']*1;   //Ensure tpe takes up integer type
  echo "<p><u><b>Pie chart for:</b></u> ".$title."</p>";
  table_maker_nmbr($values);	

   $g=0;
   $var_string=null;
   foreach($values as $dta_key => $dta_vl)
    {
	if($dta_key!=="Total")
	 $var_string[]="['".$dta_key."', ".$dta_vl."]";//['".$dta_key."', ".$dta_vl."]";
    }
   $total=number_format($values["Total"]);
   $var_string=implode(",",$var_string);
   $type="pie";
   if($tpe==2);
     include("draw_pie_chart.php");
  }
  
  
function table_maker($data)
 {
  echo "<table>";
  foreach($data as $q => $v)
   {
    echo "<tr><td>".$q."</td><td>".$v."</td></tr>";
   }
  echo "</table>";
 }
function table_maker_nmbr($data)
 {
  echo "<table>";
  foreach($data as $q => $v)
   {
    echo "<tr><td>".$q."</td><td>".number_format($v)."</td></tr>";
   }
  echo "</table>";
 }
  
?>
