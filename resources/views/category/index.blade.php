@extends ('layouts.main')

@section ('content')
<script>
	
var repData = <?php echo $categoryReport?>;	
	
$(document).ready(function(){
	var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "December"];

	var labels = [];
	var datasets = [];
	
	var labels = repData.months;	
	var data = repData.data;
	
	for (var i in data) {
		
		var el = data[i];
		
		var obj = {}; 
		
		obj.label = el.name;
		obj.fill = false;
		
		var values = [];
		
		for (var i in labels) {
			if (el.months.hasOwnProperty(labels[i])) {
				values.push(el.months[labels[i]])
			} else {
				values.push(0);
			}
		}
		
		
		var color = 'rgba('+(Math.floor(Math.random()*255))+','+(Math.floor(Math.random()*255))+','+(Math.floor(Math.random()*255))+','+' 0.5)';
		
		obj.data = values;
		obj.borderColor = color;
        obj.backgroundColor = color;
		
		datasets.push(obj);
	
	}
	
	labels = labels.map(function(i){
		return months[i-1];
	});
	
	var ctx = document.getElementById('category_report').getContext('2d');		
	var myChart = new Chart(ctx,{
		type: 'line',
		data: {
			labels: labels,
			datasets: datasets,				
		}		
	});	
	
})
</script>
<div class="row">
	<div class='panel panel-default' >
	<div class='panel-heading'>
		Отчет
	</div>	
	<div class='panel-body'>
		<div class="diagramm">
			<div >
				<canvas class='chart ' id="category_report" width="500" ></canvas>
			</div>
			<div class='legend' id="legend"></div>
			<div class='clearfix'></div>
		</div> 
	</div>
</div>
</div>
<div class="col-md-6">
	@include('category.category', ['categories'=>$outcome, 'title'=>$cat_name['outcome'], 'type'=>'outcome'])
</div>
<div class="col-md-6">
	@include('category.category', ['categories'=>$income, 'title'=>$cat_name['income'], 'type'=>'income'])
</div>
@stop

