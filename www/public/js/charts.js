var ctx = document.getElementById('turnover').getContext('2d'); //Structure du graphique chiffre d'affaires
const chartTurnover = new Chart(ctx, {
    type: 'line',
    data: {
        labels: '',
        datasets: [{
            label: 'Chiffre d\'affaires',
            data: '',
            backgroundColor: 'rgba(111,207,151,0.3)',
            borderColor: '#27AE60',
            pointBackgroundColor: '#27AE60',
            borderWidth: 1,
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    fontSize: 18,
                    padding: 20
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18,
                    suggestedMax: 10
                }
            }]
        },
        legend: {
            display: false,
            labels: {
                fontSize: 25
            }
        }
    },
    responsive: true,
    maintainAspectRatio: false,
});


var ctx = document.getElementById('chartSales').getContext('2d'); //Structure du graphique nombre de ventes
const chartSales = new Chart(ctx, {
    type: 'line',
    data: {
        labels: '',
        datasets: [{
            label: 'Ventes',
            data: '',
            backgroundColor: 'rgba(111,207,151,0.3)',
            borderColor: '#27AE60',
            pointBackgroundColor: '#27AE60',
            borderWidth: 1,
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    fontSize: 18,
                    padding: 20
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18,
                    suggestedMax: 10
                }
            }]
        },
        legend: {
            display: false,
            labels: {
                fontSize: 25
            }
        }
    }
});


getData('month', 'turnover');
getData('month', 'sales');

function getData(type, chart){ //Récupération des données

    $.ajax({
        type: 'POST',
        url: '/admin/get-data-charts',
        data: {
            type: type,
            chart: chart
        },
        success: function(data) {
            if (data === 'error'){
                alert('ERROR')
            }else{
                if (chart === 'sales'){
                    refreshChartSales(JSON.parse(data));
                }else if (chart === 'turnover'){
                    refreshChartTurnover(JSON.parse(data));
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}

//Rafraichissement des données des graphiques

function refreshChartSales(data) {
    chartSales.data.labels = data.map(o => o.name);
    chartSales.data.datasets[0].data = data.map(o => o.value);

    chartSales.update();
}

function refreshChartTurnover(data) {
    chartTurnover.data.labels = data.map(o => o.name);
    chartTurnover.data.datasets[0].data = data.map(o => o.value);

    chartTurnover.update();
}