function pieChart() {
 
 
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text: "World Energy Consumption by Sector - 2012"
        },
        data: [{
            type: "pie",
            indexLabel: "{y}",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#36454F",
            indexLabelFontSize: 18,
            indexLabelFontWeight: "bolder",
            showInLegend: true,
            legendText: "{label}",
            dataPoints: [
                { y: 80/3265*100, name: "Opieka zdrowotna" },
						{ y: 150/3265*100, name: "Ubrania" },
						{ y: 35/3265*100, name: "Higiena" },
						{ y: 150/3265*100, name: "Rozrywka" },
            ]
        }]
    });
    chart.render();
     
    }