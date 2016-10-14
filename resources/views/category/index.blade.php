@extends ('layouts.main')

@section ('content')
<script>
	
var repData = <?php echo $categoryReport?>;	
	
$(document).ready(function(){
	var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "December"];
	var colors = ['rgb(255,99,71)', 'rgb(144,238,144)', 'rgb(135,206,235)', 'rgb(255,215,0)', 'rgb(128,0,0)', 'rgb(255,165,0)', 'rgb(60,179,113)', 'rgb(0,255,255)', 'rgb(255,192,203)', 'rgb(128,0,128)', 'rgb(0,128,128)', 'rgb(128,128,128)', 'rgb(192,192,192)'];
	var datasets = [];	
	var labels = repData.months;	
	var data = repData.data;
	
	var countColor = 0;
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
		
		obj.data = values;
		obj.borderColor = colors[countColor];
        obj.backgroundColor = colors[countColor];
		countColor++;
		
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

