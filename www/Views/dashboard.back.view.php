<div class="container">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col">
        <div class="jumbotron">
            <select class="input">
                <option value="month">1 Mois</option>
                <option value="months">6 Mois</option>
                <option value="year">1 An</option>
                <option value="all">Depuis le début</option>
            </select>
            <h3 class="centered">Chiffre d'affaires</h3>
            <canvas id="turnover" width="170" height="60"></canvas>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col">
            <div class="jumbotron">
                <select class="input" id="sales" onchange="getData(this.value)">
                    <option value="month">1 Mois</option>
                    <option value="months">6 Mois</option>
                    <option value="year">1 An</option>
                    <option value="all">Depuis le début</option>
                </select>
                <h3 class="centered">Ventes</h3>
                <canvas id="chartSales" width="170" height="60"></canvas>
            </div>
        </div>

    </div>
</div>


Operarios:
<select id="operator" onchange="refreshChart(this.value)">
    <option>All</option>
</select>
<canvas id="orders" height="90"></canvas>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="../public/js/charts.js"></script>