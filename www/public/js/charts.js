var ctx = document.getElementById('turnover').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Chiffre d\'affaire',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(111,207,151,0.3)',
            borderColor: '#27AE60',
            pointBackgroundColor: '#27AE60',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    fontSize: 18
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18
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

var arraySales = [
    { name: 'Janvier', orders_by_user: '12' },
    { name: 'Février', orders_by_user: '19' },
    { name: 'Mars', orders_by_user: '3' },
    { name: 'Avril', orders_by_user: '5' },
    { name: 'Mai', orders_by_user: '2' },
    { name: 'Juin', orders_by_user: '3' }
];

var ctx = document.getElementById('chartSales').getContext('2d');
const chartSales = new Chart(ctx, {
    type: 'line',
    data: {
        labels: arraySales.map(o => o.name),
        datasets: [{
            label: 'Ventes',
            data: [12, 19, 3, 5, 2, 1000],
            backgroundColor: 'rgba(111,207,151,0.3)',
            borderColor: '#27AE60',
            pointBackgroundColor: '#27AE60',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    fontSize: 18
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18
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


orders = [
    { name: 'Luis', orders_by_user: '2' },
    { name: 'Jose', orders_by_user: '1' },
    { name: 'Miguel', orders_by_user: '3' }
];
console.log(orders);
var myChart = new Chart(document.getElementById('orders'), {
    type: 'bar',
    data: {
        labels: orders.map(o => o.name),
        datasets: [{
            label: 'Terminadas',
            data: orders.map(o => o.orders_by_user),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: "#229954",
            borderWidth: 1,
            yAxisID: 'Ordenes',
            xAxisID: 'Operarios',
        }]
    },
    options: {
        scales: {
            yAxes: [{
                id: "Ordenes",
                ticks: {
                    beginAtZero: true,
                    stepSize: 1
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Ordenes'
                }
            }],
            xAxes: [{
                id: "Operarios",
                scaleLabel: {
                    display: true,
                    labelString: 'Operarios'
                }

            }],
        },
        title: {
            display: true,
            text: "Ordenes en estado terminado"
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                fontColor: "#17202A",
            }
        },
    }
});
//
// orders.forEach(o => {
//     const opt = document.createElement('option');
//     opt.value = o.name;
//     opt.appendChild(document.createTextNode(o.name));
//     document.getElementById('operator').appendChild(opt);
// });
//
// function refreshChart(name) {
//     myChart.data.labels = [name];
//     if (name == 'All') {
//         myChart.data.labels = orders.map(o => o.name),
//             myChart.data.datasets[0].data = orders.map(o => o.orders_by_user);
//     } else {
//         myChart.data.labels = [name];
//         myChart.data.datasets[0].data = orders.find(o => o.name == name).orders_by_user;
//     }
//     myChart.update();
// }
getData("month");

function getData(type){
    $.ajax({
        type: 'POST',
        url: '/admin/get-data-charts',
        data: {
            type: type
        },
        success: function(data) {
            console.log(JSON.parse(data));
            refreshChartSales(JSON.parse(data));
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}

function refreshChartSales(data) {
    chartSales.data.labels = data.map(o => o.name);
    chartSales.data.datasets[0].data = data.map(o => o.orders_by_user);

    chartSales.update();
}