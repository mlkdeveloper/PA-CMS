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
                    max: 50,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18
                }
            }]
        },
        legend: {
            labels: {
                fontSize: 25
            }
        }
    }
});

var ctx = document.getElementById('sales').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Ventes',
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
                    max: 50,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18
                }
            }]
        },
        legend: {
            labels: {
                fontSize: 25
            }
        }
    }
});


var ctx = document.getElementById('visitors').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Visiteurs',
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
                    max: 50,
                    responsive: true,
                    maintainAspectRatio: false,
                    fontSize: 18
                }
            }]
        },
        legend: {
            labels: {
                fontSize: 25
            }
        }
    }
});

