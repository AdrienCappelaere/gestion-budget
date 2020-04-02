function get_chart($category,$data) {
  
    var ctx = document.getElementById('myChart-category').getContext('2d');
    var myLegendContainer = document.getElementById("myChartLegend-category");
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: $category,
          datasets: [
            {
              label: "Dépenses (en €)",
              backgroundColor: ["#1D8BDB", "#DB6732","#12DBC4","#DBB007","#2732DB","#1D8BDB","#DB6732","#12DBC4","#DBB007","#2732DB","#1D8BDB", "#DB6732","#12DBC4","#DBB007","#2732DB",],
              data: $data
            }
          ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
              },
            legendCallback: function(chart) {
              var legendHtml = [];
              legendHtml.push('<ul class="chart-category-ul">');
              var item = chart.data.datasets[0];
              for (var i=0; i < item.data.length; i++) {
                  legendHtml.push('<li>');
                  legendHtml.push('<span class="chart-legend" style="background-color:' + item.backgroundColor[i] +'"></span>');
                  legendHtml.push('<span class="chart-legend-label-text">' +chart.data.labels[i]  + ' : '+item.data[i]+' €</span>');
                  legendHtml.push('</li>');
              }
  
              legendHtml.push('</ul>');
              return legendHtml.join("");
            }
    }
  }
  );

    myLegendContainer.innerHTML = chart.generateLegend();
    }

function get_chart_total($date,$data_solde,$revenu,$depense) {
  var ctx = document.getElementById('myChart-total').getContext('2d');
  var myLegendContainerTotal = document.getElementById("myChartLegend-total");
  var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: $date,
        datasets: [
          {
            label: "Solde total",
            type: "line",
            backgroundColor: "#1d8bdb",
            borderColor: "#1d8bdb",
            data: $data_solde,
            fill: false
          } , {
            label: "Dépenses (en €)",
            backgroundColor: "rgba(199,0,0,0.7)",
            data: $depense
          } , {
            label: "Revenus (en €)",
            backgroundColor: "rgba(34,150,32,0.7)",
            data: $revenu
          } 
        ]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
              display: false
            },
            scales: {
              xAxes: [{
                  stacked: true,
                  barThickness:25
              }],
              yAxes: [{
                  stacked: true
              }]
          },

            legendCallback: function(chart) {
              var legendHtml = [];
              legendHtml.push('<ul class="chart-category-ul">');
              var item = chart.data;
                for (var i=0; i < item.datasets.length; i++) {
                    legendHtml.push('<li>');
                    legendHtml.push('<span class="chart-legend" style="background-color:' + item.datasets[i].backgroundColor +'"></span>');
                    legendHtml.push('<span class="chart-legend-label-text">'+ item.datasets[i].label +'</span>');
                    legendHtml.push('</li>');
                }
  
              legendHtml.push('</ul>');
              return legendHtml.join("");
            }
  }});

  myLegendContainerTotal.innerHTML = chart.generateLegend();
}
