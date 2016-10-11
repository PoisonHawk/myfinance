<script>
	
var repData = <?php echo $operationReports?>;	
	
$(document).ready(function(){
	
	var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "December"];

	var labels = [];
	var income = [];
	var outcome = [];
	
	for (var i in repData) {
		
		console.log(repData[i].month-1);
		
		labels.unshift(months[repData[i].month-1]);
		income.unshift(repData[i].income);
		outcome.unshift(repData[i].outcome);
	}
	
	var ctx = document.getElementById('outcomes_month').getContext('2d');
	var data = {
		labels: labels,
		datasets: [
			{
				label: "Income",
				fillColor: [
					'LightGreen',				
				],
				data: income,
			},
			{
				label: "Outcome",
				fillColor: [
					'Tomato',				
				],
				data: outcome,
			}
		],		
	};
	
	var myChart = new Chart(ctx).Bar(data, {
		
		responsive: true,
		
	});	
	
})
</script>
<!--
--><div class='panel panel-default'>
	<div class='panel-heading'>
		Расходы по месяцам
	</div><!--
	<img src="/img/preload.gif" ng-show="loading" class="center-block">
	--><div class='panel-body'>
		<canvas id="outcomes_month" width="600" height="300"></canvas>
	</div>
	
</div>

